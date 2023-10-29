<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->user()
                ->tokens()
                ->where(
                    'id',
                    $request->user()
                        ->currentAccessToken()
                        ->id
                )
                ->delete();

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "logout berhasil!", MessageFixer::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
