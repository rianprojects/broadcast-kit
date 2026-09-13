<?php
namespace App\Controllers;

use App\Libraries\TriPayLib;
use App\Models\TransactionModel;
use App\Models\UserPromptModel;

class Callback extends BaseController
{
    public function tripay()
    {
        $rawBody = $this->request->getBody();
        $signature = $this->request->getHeaderLine('X-Callback-Signature');

        if (!(new TriPayLib())->verifyCallbackSignature($rawBody, $signature)) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Invalid signature']);
        }

        $payload = json_decode($rawBody, true);
        if (!$payload || !isset($payload['merchant_ref'])) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Invalid payload']);
        }

        $transModel = new TransactionModel();
        $trans = $transModel->where('merchant_ref', $payload['merchant_ref'])->first();

        if (!$trans) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Transaction not found']);
        }

        if ($payload['status'] === 'PAID' && $trans['status'] !== 'approved') {
            $transModel->update($trans['id'], ['status' => 'approved']);

            $userPromptModel = new UserPromptModel();
            $exists = $userPromptModel->where('user_id', $trans['user_id'])
                                       ->where('prompt_id', $trans['prompt_id'])
                                       ->first();
            if (!$exists) {
                $userPromptModel->save([
                    'user_id'   => $trans['user_id'],
                    'prompt_id' => $trans['prompt_id'],
                ]);
            }
        } elseif (in_array($payload['status'], ['EXPIRED', 'FAILED'])) {
            $transModel->update($trans['id'], ['status' => 'rejected']);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
