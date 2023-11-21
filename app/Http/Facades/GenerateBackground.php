<?php

namespace App\Http\Facades;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GenerateBackground
{
    public static function buildWebinar($text)
    {
        $template = imagecreatefrompng(public_path('assets/images/frame_webinar.png'));
        $whiteColor = imagecolorallocate($template, 0, 0, 0);
        $font = public_path('assets/fonts/Nunito-Bold.ttf');

        $maxWidth = 1020;

        $textArray = explode(" ", $text);
        $lines = [];
        $currentLine = "";

        foreach ($textArray as $word) {
            $testLine = $currentLine . " " . $word;
            if (self::calculateTextWidth($testLine, $font, 85) <= $maxWidth) {
                $currentLine = $testLine;
            } else {
                $lines[] = trim($currentLine);
                $currentLine = $word;
            }
        }

        if (!empty($currentLine)) {
            $lines[] = trim($currentLine);
        }

        $y = 400;

        foreach ($lines as $line) {
            imagettftext($template, 85, 0, 200, $y, $whiteColor, $font, $line);
            $y += 150;
        }

        header("Content-type: image/png");
        imagepng($template);
    }

    public static function buildMembercard($user)
    {
        $memberCreatedAt = Carbon::createFromFormat("Y-m-d H:i:s", $user->membership->created_at);

        $template = imagecreatefrompng(public_path('assets/images/frame_membercard.png'));
        $blackColor = imagecolorallocate($template, 0, 0, 0);
        $redColor = imagecolorallocate($template, 220, 52, 50);
        $font = public_path('assets/fonts/Nunito-Bold.ttf');
        $imageProfile = imagecreatefromjpeg(public_path('assets/images/pas_photo/' . date('dmY', strtotime($user->membership->created_at)) . '/' . $user->membership->pas_photo));
        $qrcode = imagecreatefrompng(public_path('assets/images/qrcode/' . $user->id . '.png'));

        imagecopy($template, $imageProfile, 130, 235, 0, 0, 300, 400);
        imagecopy($template, $qrcode, 1459, 650, 0, 0, 400, 400);

        imagettftext($template, 50, 0, 490, 420, $blackColor, $font, $user->name);
        imagettftext($template, 50, 0, 490, 520, $redColor, $font, "Member Aplikasi");
        imagettftext($template, 50, 0, 490, 620, $blackColor, $font, $memberCreatedAt->isoFormat('YYYY'));
        imagettftext($template, 50, 0, 680, 620, $blackColor, $font, $memberCreatedAt->isoFormat('MM'));
        imagettftext($template, 50, 0, 800, 620, $blackColor, $font, $memberCreatedAt->isoFormat('DD'));
        imagettftext($template, 50, 0, 910, 620, $blackColor, $font, "00" . $user::MEMBER_APP);
        imagettftext($template, 50, 0, 1055, 620, $blackColor, $font, "0001");
        imagettftext($template, 40, 0, 960, 940, $blackColor, $font, "Anggota Sejak :");
        imagettftext($template, 40, 0, 950, 1020, $blackColor, $font, Str::upper($memberCreatedAt->isoFormat('MMMM YYYY')));

        $text = ucwords($user->membership->address);
        $textArray = explode(" ", $text);
        $lines = [];
        $currentLine = "";

        foreach ($textArray as $word) {
            $testLine = $currentLine . " " . $word;
            if (self::calculateTextWidth($testLine, $font, 85) <= 1320) {
                $currentLine = $testLine;
            } else {
                $lines[] = trim($currentLine);
                $currentLine = $word;
            }
        }

        if (!empty($currentLine)) {
            $lines[] = trim($currentLine);
        }

        $y = 780;
        foreach ($lines as $line) {
            imagettftext($template, 40, 0, 130, $y, $blackColor, $font, $line);
            $y += 55;
        }

        header("Content-type: image/png");
        imagepng($template);
    }

    protected static function calculateTextWidth($text, $font, $fontSize)
    {
        $bbox = imagettfbbox($fontSize, 0, $font, $text);
        return $bbox[4] - $bbox[0];
    }
}
