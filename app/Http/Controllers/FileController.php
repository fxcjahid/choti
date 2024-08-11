<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UploadMediaRequest;
use Illuminate\Support\Facades\Session;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class FileController extends Controller
{
    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = File::class;

    public function index()
    {
        $table = $allFile = File::orderBy('id', 'DESC')->paginate(5);  //get first 25 rows;

        return view('admin.views.media.index', compact('table'));
    }

    /**
     * Store a newly created media in storage.
     * 
     */
    public function store(UploadMediaRequest $request)
    {
        $files = $request->file('file');

        /**
         * Array Files Object
         */
        if (! empty($files) && is_array($files)) {
            foreach ($files as $file) {
                $this->uploadFileToDatabase($file);
            }
        } else {
            $this->uploadFileToDatabase($files);
        }
    }

    /**
     * Update Files details Into Database
     */
    public function uploadFileToDatabase($file)
    {
        /**
         * @@Remember: all requested files are Optimize By laravel-image-optimizer
         * @source: https://github.com/spatie/laravel-image-optimizer
         * @tools: https://github.com/spatie/image-optimizer#optimization-tools
         * @uses: Requested files are optimize by Middleware
         * @middleare: app/Http/Kernel.php
         * @config: config/image-optimizer.php
         * @required:
         *   ---> gd
         *   ---> imagick
         *   ---> JpegOptim
         *   ---> JOptipng
         *   ---> Pngquant 2
         *   ---> SVGO 1
         *   ---> Gifsicle
         *   ---> cwebp
         * 	Without those packages, The Optimize will not worked.
         *  Please, Make sure you have installed all required packages in your server
         */

        /**
         * Storage orginal file with Size Opimized
         * Place File to PUBLIC location
         */

        $path = Storage::putFile('media', $file);

        // if (
        // 	Image::load($file)->getWidth() <= 1000
        // ) {
        // 	$path = Storage::putFile('media', $file);
        // } else {

        // 	$path = sprintf(
        // 		'%s-%s.%s',
        // 		Str::random(),
        // 		Str::uuid()->toString(),
        // 		$file->extension()
        // 	);

        // 	Image::load($file)
        // 		->width(1000)
        // 		->save(public_path('media/') . Str::of($path)->afterLast('/'));
        // }

        /**
         * Storage Small size (150x150)
         * Storage Medium size (400x400)
         * Modifying the image so it fits in canvas
         * rectangle without altering aspect ratio
         * @source: https://github.com/spatie/image#manipulate-images-with-an-expressive-api
         * @return string path
         */
        // Image::load($file)
        // 	->width(150)
        // 	->height(150)
        // 	->save(public_path('media/small/') .  Str::of($path)->afterLast('/'));

        // Image::load($file)
        // 	->width(400)
        // 	->height(400)
        // 	->watermark(public_path('/assets/public/img/') . 'watermark.png')
        // 	->watermarkPosition(Manipulations::POSITION_BOTTOM_RIGHT)
        // 	->watermarkWidth(12, Manipulations::UNIT_PERCENT)
        // 	->watermarkHeight(10, Manipulations::UNIT_PERCENT)
        // 	->watermarkPadding(10)
        // 	->save(public_path('media/medium/') .  Str::of($path)->afterLast('/'));

        //Insert File details to Database
        $File = File::create([
            'user_id'   => auth()->id(),
            'disk'      => config('filesystems.default'),
            'filename'  => $file->getClientOriginalName(),
            'path'      => $path,
            'small'     => $path,
            'medium'    => $path,
            'extension' => $file->guessClientExtension() ?? '',
            'mime'      => $file->getClientMimeType(),
            'size'      => $file->getSize(),
        ]);

        Session::flash('success', 'File was upload successfully');
        return response(
            [
                'success' => true,
                'File'    => $File,
            ],
        );
    }

    /**
     * EditorJS (Image Uploader)
     * Store a newly created media in storage from EditoJS plugin.
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(UploadMediaRequest $request)
    {
        $file = $request->file('image');

        if (! empty($file)) {


            // Place File to PUBLIC location

            $path = Storage::putFile('media', $file);

            // if (
            // 	Image::load($file)->getWidth() <= 1000
            // ) {
            // 	$path = Storage::putFile('media', $file);
            // } else {

            // 	$path = sprintf(
            // 		'%s-%s.%s',
            // 		Str::random(),
            // 		Str::uuid()->toString(),
            // 		$file->extension()
            // 	);

            // 	Image::load($file)
            // 		->width(1000)
            // 		->save(public_path('media/') . Str::of($path)->afterLast('/'));
            // }

            // Insert File details to Database
            File::create([
                'user_id'   => auth()->id(),
                'disk'      => config('filesystems.default'),
                'filename'  => $file->getClientOriginalName(),
                'path'      => $path,
                'small'     => $path,
                'medium'    => $path,
                'extension' => $file->extension() ?? '',
                'mime'      => $file->getClientMimeType(),
                'size'      => $file->getSize(),
            ]);

            return response()->json(
                [
                    "success" => 1,
                    "file"    => [
                        "url"     => Storage::disk(config('filesystems.default'))->url($path),
                        "caption" => $file->getClientOriginalName(),
                    ],
                ],
            );
        }
    }

    /**
     * EditorJS (Image Uploader) By URL
     * Store a newly created media in storage from EditoJS plugin.
     * @return \Illuminate\Http\Response
     */
    public function uploadURL(UploadMediaRequest $request)
    {
        $file = $request->input('url');

        if (! empty($file)) {

            $contents      = file_get_contents($file);
            $FileInfo      = pathinfo($file);
            $FileName      = (strlen($FileInfo['filename']) <= 200) ? $FileInfo['filename'] : Str::random(40);
            $FileExtension = strtolower('png');
            $FileMimeType  = sprintf('image/%s', $FileExtension);
            $FilePath      = sprintf('media/%s-%s.%s', uniqid(), $FileName, $FileExtension);


            Storage::put($FilePath, $contents);

            /**
             * Insert File details to Database
             **/
            File::create([
                'user_id'   => auth()->id(),
                'disk'      => config('filesystems.default'),
                'filename'  => $FileName,
                'path'      => $FilePath,
                'small'     => $FilePath,
                'medium'    => $FilePath,
                'extension' => $FileExtension ?? '',
                'mime'      => $FileMimeType,
                'size'      => 0,
            ]);

            return response()->json(
                [
                    "success" => 1,
                    "file"    => [
                        "url"     => Storage::disk(config('filesystems.default'))->url($FilePath),
                        "caption" => $FileName,
                    ],
                ],
            );
        }
    }
}