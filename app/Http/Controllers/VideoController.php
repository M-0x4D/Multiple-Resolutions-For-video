<?php


namespace App\Http\Controllers;

use FFMpeg\Coordinate\Dimension;
use Illuminate\Http\Request;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;


class VideoController extends Controller
{

    public function upload(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000', // Adjust the max size as needed
            ]);

            // Handle the video upload
            if ($request->hasFile('video')) {
                $video = $request->file('video');
                $filename = time() . '.' . $video->getClientOriginalExtension();
                $path = storage_path('app/public/videos/');

                // Create the directory if it doesn't exist
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                // Save the original video
                $video->move($path, $filename);

                // Define resolutions
                $resolutions = [
                    '240p' => [426, 240],
                    // '360p' => [640, 360],
                    // '480p' => [854, 480],
                    // '720p' => [1280, 720],
                    // '1080p' => [1920, 1080],
                ];

                foreach ($resolutions as $label => $dimensions) {
                    $width = $dimensions[0];
                    $height = $dimensions[1];

                    // Initialize FFMpeg
                    $ffmpeg = FFMpeg::create();
                    $video = $ffmpeg->open($path . $filename);

                    // Create the format
                    $format = new X264('libmp3lame', 'libx264');
                    $format->setKiloBitrate(1000);

                    // Save the resized video
                    $video->filters()->resize(new Dimension($width, $height))->synchronize();
                    $video->save($format, $path . $label . '_' . $filename);
                }

                return view('upload', ['successMessage' => 'success', 'video' => "storage/videos/240p_{$filename}", 'fileName' => $filename]);
            }

            return view('upload', ['errorMessage' => 'there is no video file']);
        } catch (\Throwable $th) {
            return view('upload', ['errorMessage' => $th->getMessage()]);
        }
    }

    function getVideoWithFitResolution(Request $request)
    {
        $fileName = $request->name;
        $speed = $request->speed ?? 1;
        $url = '';
        switch ($speed) {
            case $speed < 2:
                # code...
                $url = "storage/videos/240p_{$fileName}";
                break;
            case $speed < 3:
                # code...
                $url = "storage/videos/360p_{$fileName}";
                break;

            case $speed < 4:
                # code...
                $url = "storage/videos/480p_{$fileName}";
                break;
            case $speed < 5:
                # code...
                $url = "storage/videos/720p_{$fileName}";
                break;
            case $speed < 6:
                # code...
                $url = "storage/videos/1080p_{$fileName}";
                break;
            case $speed < 7:
                # code...
                $url = "storage/videos/360p_{$fileName}";
                break;

            default:
                # code...
                $url = "storage/videos/240p_{$fileName}";
                break;
        }
        $url = 'http://localhost:8000/'. $url;

        return response()->json(['url' => $url]);
    }
}
