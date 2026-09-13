<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TelegramProdukModel;
use App\Models\TelegramProductItemModel;
use App\Models\TransaksiModel;
use App\Models\TelegramKategoriModel;
use App\Libraries\TriPayLib;

class Api extends ResourceController
{
    public function getCategories()
    {
        $kategoriModel = new TelegramKategoriModel();
        return $this->respond($kategoriModel->findAll(), 200);
    }

    public function addCategory()
    {
        $json = $this->request->getJSON();
        if (!$json || !isset($json->category_name)) {
            return $this->fail('Invalid Data', 400);
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $json->category_name)));

        $db = \Config\Database::connect();
        $db->table('telegram_categories')->insert([
            'category_name' => $json->category_name,
            'slug' => $slug
        ]);

        return $this->respondCreated(['status' => 'success']);
    }

    public function deleteCategory()
    {
        $json = $this->request->getJSON();
        if (!$json || !isset($json->id)) {
            return $this->fail('Invalid Data', 400);
        }

        $db = \Config\Database::connect();
        $db->table('telegram_products')->where('category_id', $json->id)->update(['category_id' => null]);
        $db->table('telegram_categories')->where('id', $json->id)->delete();

        return $this->respondDeleted(['status' => 'success']);
    }

    public function addProduct()
    {
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->fail('Invalid Data', 400);
        }

        $telegramProdukModel = new TelegramProdukModel();
        $itemModel = new TelegramProductItemModel();

        $sku = 'TG-' . time();
        $mediaType = $json->media_type ?? 'teks';
        $stock = 999;
        $itemsArray = [];

        if ($mediaType === 'batch') {
            $itemsArray = array_filter(array_map('trim', explode("\n", $json->digital_content)));
            $stock = count($itemsArray);
            if ($stock === 0) {
                return $this->fail('Batch tidak boleh kosong', 400);
            }
        }

        $data = [
            'sku_code'        => $sku,
            'category_id'     => isset($json->category_id) ? (int)$json->category_id : null,
            'product_name'    => $json->product_name,
            'price'           => $json->price,
            'stock'           => $stock,
            'media_type'      => $mediaType,
            'digital_content' => $mediaType === 'batch' ? 'Produk Batch/Voucher' : $json->digital_content,
            'is_active'       => 1
        ];

        $telegramProdukModel->insert($data);

        if ($mediaType === 'batch' && count($itemsArray) > 0) {
            $batchData = [];
            foreach ($itemsArray as $itemText) {
                $batchData[] = [
                    'product_sku'  => $sku,
                    'item_content' => $itemText,
                    'is_sold'      => 0
                ];
            }
            $itemModel->insertBatch($batchData);
        }

        return $this->respondCreated(['status' => 'success', 'sku' => $sku]);
    }

    public function getTelegramProducts()
    {
        $telegramProdukModel = new TelegramProdukModel();
        $products = $telegramProdukModel->where('is_active', 1)->orderBy('category_id', 'ASC')->findAll();
        return $this->respond($products, 200);
    }

    public function deleteProduct()
    {
        $json = $this->request->getJSON();
        if (!$json || !isset($json->sku)) {
            return $this->fail('Invalid Data', 400);
        }

        $telegramProdukModel = new TelegramProdukModel();
        $itemModel = new TelegramProductItemModel();

        $product = $telegramProdukModel->where('sku_code', $json->sku)->first();

        if (!$product) {
            return $this->fail('Product not found', 404);
        }

        $itemModel->where('product_sku', $json->sku)->delete();
        $telegramProdukModel->delete($product['id']);

        return $this->respondDeleted(['status' => 'success']);
    }

    public function getUserBalance($telegramId)
    {
        $db = \Config\Database::connect();
        $row = $db->table('user_balances')->where('telegram_id', $telegramId)->get()->getRowArray();
        $balance = $row ? (float)$row['balance'] : 0.00;
        return $this->respond(['telegram_id' => $telegramId, 'balance' => $balance], 200);
    }

    public function addManualBalance()
    {
        $json = $this->request->getJSON();
        if (!$json || !isset($json->telegram_id) || !isset($json->amount)) {
            return $this->fail('Invalid Data', 400);
        }

        $db = \Config\Database::connect();
        $telegramId = $json->telegram_id;
        $amount = (float) $json->amount;

        $userBalance = $db->table('user_balances')->where('telegram_id', $telegramId)->get()->getRowArray();

        if ($userBalance) {
            $db->table('user_balances')->where('telegram_id', $telegramId)->update([
                'balance' => $userBalance['balance'] + $amount
            ]);
        } else {
            $db->table('user_balances')->insert([
                'telegram_id' => $telegramId,
                'balance' => $amount
            ]);
        }

        $db->table('balance_logs')->insert([
            'telegram_id' => $telegramId,
            'type'        => 'IN',
            'amount'      => $amount,
            'description' => 'Manual Topup by Admin'
        ]);

        return $this->respond(['status' => 'success']);
    }

    public function checkActiveDeposit($telegramId)
    {
        $transaksiModel = new TransaksiModel();
        $activeTx = $transaksiModel->where('customer_target', $telegramId)
                                   ->where('status', 'UNPAID')
                                   ->like('product_sku', 'DEP-', 'after')
                                   ->first();

        if ($activeTx) {
            return $this->respond([
                'has_active' => true,
                'amount'     => (int) $activeTx['total_amount']
            ], 200);
        }

        return $this->respond(['has_active' => false], 200);
    }

    public function createBotTransaction()
    {
        $json = $this->request->getJSON();
        if (!$json) {
            return $this->fail('Invalid Data', 400);
        }

        $db = \Config\Database::connect();
        $telegramProdukModel = new TelegramProdukModel();
        $transaksiModel = new TransaksiModel();

        // [RPL] Handle REG-RL — biaya pendaftaran RPL tanpa stok produk
        if ($json->sku === 'REG-RL') {
            $productPrice = (int) ($json->amount ?? 200000);
            $productName = $json->product_name ?? 'Biaya Pendaftaran';
            $product = null;
        } elseif (strpos($json->sku, 'DEP-') === 0) {
            $productPrice = (int) str_replace('DEP-', '', $json->sku);
            $productName = 'Top Up Saldo Rp ' . number_format($productPrice, 0, ',', '.');
            $product = null;
        } else {
            $product = $telegramProdukModel->where('sku_code', $json->sku)->first();
            if (!$product) {
                return $this->fail('Product not found', 404);
            }
            $productPrice = (int) $product['price'];
            $productName = $product['product_name'];
        }

        if (isset($json->use_balance) && $json->use_balance === true) {
            $userBalanceRow = $db->table('user_balances')->where('telegram_id', $json->telegram_id)->get()->getRowArray();
            $currentBalance = $userBalanceRow['balance'] ?? 0;

            if ($currentBalance < $productPrice) {
                return $this->fail('Saldo tidak mencukupi', 400);
            }

            $db->table('user_balances')->where('telegram_id', $json->telegram_id)->update([
                'balance' => $currentBalance - $productPrice
            ]);

            $merchantRef = 'IZUMI-BAL-' . time();
            $digitalContent = "Produk sedang diproses...";

            if ($product) {
                if ($product['media_type'] === 'batch') {
                    $itemModel = new TelegramProductItemModel();
                    $item = $itemModel->where('product_sku', $json->sku)->where('is_sold', 0)->first();
                    if ($item) {
                        $itemModel->update($item['id'], ['is_sold' => 1, 'sold_to' => $json->telegram_id]);
                        $digitalContent = $item['item_content'];
                        $telegramProdukModel->update($product['id'], ['stock' => $product['stock'] - 1]);
                    } else {
                        $digitalContent = "Mohon maaf, stok voucher habis. Saldo akan di-refund.";
                    }
                } else {
                    $digitalContent = $product['digital_content'];
                }
            }

            $transaksiModel->save([
                'invoice_id'     => $merchantRef,
                'reference'      => $merchantRef,
                'merchant_ref'   => $merchantRef,
                'payment_method' => 'SALDO INTERNAL',
                'total_amount'   => $productPrice,
                'customer_email' => $json->email,
                'customer_target'=> $json->telegram_id,
                'product_sku'    => $json->sku,
                'status'         => 'PAID',
                'discount_amount'=> 0,
                'coupon_code'    => ''
            ]);

            return $this->respond([
                'status' => 'success_saldo',
                'amount' => $productPrice,
                'product_name' => $productName,
                'digital_content' => $digitalContent
            ]);
        }

        $tripay = new TriPayLib();
        $merchantRef = $json->merchant_ref ?? ('IZUMI-' . time());
        $customerTarget = $json->customer_target ?? $json->email ?? '';
        $callbackUrl = $json->callback_url ?? '';
        $returnUrl = $json->return_url ?? ($callbackUrl ? str_replace('/tripay/callback', '/pendaftaran/terimakasih', $callbackUrl) : '');
        $tripayResponse = $tripay->requestTransaction($merchantRef, $productPrice, $json->payment_method, $productName, $json->email, '081234567890', $returnUrl);

        if (!$tripayResponse || !$tripayResponse['success']) {
            return $this->fail($tripayResponse['message'] ?? 'Tripay Error', 500);
        }

        $tripayData = $tripayResponse['data'];
        $transaksiModel->save([
            'invoice_id'     => $merchantRef,
            'reference'      => $tripayData['reference'],
            'merchant_ref'   => $merchantRef,
            'payment_method' => $tripayData['payment_name'],
            'total_amount'   => $tripayData['amount'],
            'customer_email' => $json->email,
            'customer_target'=> $customerTarget,
            'product_sku'    => $json->sku,
            'status'         => 'UNPAID',
            'discount_amount'=> 0,
            'coupon_code'    => ''
        ]);

        // Simpan callback_url di session atau notes untuk dipakai saat callback
        if ($callbackUrl) {
            $db->table('transactions')
               ->where('merchant_ref', $merchantRef)
               ->update(['digiflazz_message' => 'callback:' . $callbackUrl]);
        }

        return $this->respond([
            'status' => 'success_tripay',
            'reference' => $tripayData['reference'],
            'merchant_ref' => $merchantRef,
            'qr_url' => $tripayData['qr_url'] ?? null,
            'checkout_url' => $tripayData['checkout_url'] ?? null,
            'payment_method' => $tripayData['payment_name'],
            'amount' => $tripayData['amount'],
            'expired_time' => $tripayData['expired_time'] ?? null
        ]);
    }
    
    public function checkTransactionStatus($merchantRef)
    {
        $transaksiModel = new TransaksiModel();
        $tx = $transaksiModel->where('merchant_ref', $merchantRef)->first();
        if (!$tx) return $this->fail('Not found', 404);
        return $this->respond(['status' => $tx['status']], 200);
    }

    public function paymentChannels()
    {
        $tripay = new TriPayLib();
        $channels = $tripay->getPaymentChannels();
        if ($channels && isset($channels['success']) && $channels['success']) {
            return $this->respond(['success' => true, 'data' => $channels['data']]);
        }
        return $this->respond(['success' => false, 'message' => 'Gagal memuat channel'], 500);
    }

    public function getBusinessRecap()
    {

        $secretKey = getenv('IZUMI_API_KEY');
        $headerKey = $this->request->getHeaderLine('KysitestoreIzumi2026!');

        if ($headerKey !== $secretKey) {
            return $this->failUnauthorized('Akses Ditolak! API Key tidak valid.');
        }

        $db = \Config\Database::connect();
        
        $totalSaldo = $db->query("SELECT SUM(balance) as total FROM user_balances")->getRow()->total;
        $totalTrx = $db->query("SELECT SUM(total_amount) as total FROM transactions WHERE status = 'SUCCESS'")->getRow()->total;
        $totalUsers = $db->query("SELECT COUNT(id) as total FROM user_balances")->getRow()->total;

        $recentTrx = $db->query("SELECT merchant_ref, payment_method, total_amount, product_sku, status FROM transactions ORDER BY id DESC LIMIT 15")->getResultArray();

        return $this->respond([
            'total_saldo_mengendap' => (float)($totalSaldo ?? 0),
            'total_pendapatan_kotor' => (float)($totalTrx ?? 0),
            'total_user_aktif' => (int)($totalUsers ?? 0),
            'recent_transactions' => $recentTrx
        ], 200);
    }
}