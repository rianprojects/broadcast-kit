<!--<?php if (session()->getFlashdata('success')) : ?>-->
<!--    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 flex justify-between items-start shadow-sm">-->
<!--        <div class="flex gap-3">-->
<!--            <i class="fa-solid fa-circle-check text-xl mt-0.5"></i>-->
<!--            <div>-->
<!--                <h4 class="font-bold text-sm">Berhasil!</h4>-->
<!--                <p class="text-sm mt-1"><?= session()->getFlashdata('success') ?></p>-->
<!--            </div>-->
<!--        </div>-->
<!--        <button @click="show = false" class="text-emerald-500 hover:bg-emerald-100 dark:hover:bg-emerald-800/50 p-1 rounded-full transition">-->
<!--            <i class="fa-solid fa-xmark"></i>-->
<!--        </button>-->
<!--    </div>-->
<!--<?php endif; ?>-->

<!--<?php if (session()->getFlashdata('error')) : ?>-->
<!--    <?php $error = session()->getFlashdata('error'); ?>-->
<!--    <?php if (!is_array($error)) : ?>-->
<!--        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 flex justify-between items-start shadow-sm">-->
<!--            <div class="flex gap-3">-->
<!--                <i class="fa-solid fa-circle-exclamation text-xl mt-0.5"></i>-->
<!--                <div>-->
<!--                    <h4 class="font-bold text-sm">Terjadi Kesalahan!</h4>-->
<!--                    <p class="text-sm mt-1"><?= $error ?></p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <button @click="show = false" class="text-red-500 hover:bg-red-100 dark:hover:bg-red-800/50 p-1 rounded-full transition">-->
<!--                <i class="fa-solid fa-xmark"></i>-->
<!--            </button>-->
<!--        </div>-->
<!--    <?php endif; ?>-->
<!--<?php endif; ?>-->

<!--<?php if (session()->getFlashdata('error') && is_array(session()->getFlashdata('error'))) : ?>-->
<!--    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 flex justify-between items-start shadow-sm">-->
<!--        <div class="flex gap-3">-->
<!--            <i class="fa-solid fa-triangle-exclamation text-xl mt-0.5"></i>-->
<!--            <div>-->
<!--                <h4 class="font-bold text-sm">Validasi Gagal!</h4>-->
<!--                <ul class="list-disc list-inside text-sm mt-1 space-y-1">-->
<!--                    <?php foreach (session()->getFlashdata('error') as $err) : ?>-->
<!--                        <li><?= esc($err) ?></li>-->
<!--                    <?php endforeach ?>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--        <button @click="show = false" class="text-red-500 hover:bg-red-100 dark:hover:bg-red-800/50 p-1 rounded-full transition">-->
<!--            <i class="fa-solid fa-xmark"></i>-->
<!--        </button>-->
<!--    </div>-->
<!--<?php endif; ?>-->