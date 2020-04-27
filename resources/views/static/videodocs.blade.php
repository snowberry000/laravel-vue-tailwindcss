<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto">
        <div class=" m-5 p-10 bg-gray-100 border border-gray-200 shadow-3xl">
            <img src="{{asset('images/logo.svg')}}" alt="yayimages" class="w-64 mx-auto mt-5" />
            <h1 class="mb-5 text-xl font-light text-center uppercase">Video Contributor Guide</h1>
            <p class="mb-2">
                YAYIMAGES providing a possibility to have an early access to sell video on YAYIMAGES, to get your access
                you need to be
                approved by YAYIMAGES staff. Together with video files you will also need to upload an csv file
                containing required
                meta information, you can also submit meta information to each and every file in
                <a class="text-blue-500" href="https://contributors.yayimages.com">contributors.yayimages.com</a> portal
            </p>
            <h2 class="text-lg my-2 font-bold uppercase">Supported formats and limitations</h2>
            <p class="my-2">Currently we support uploading of mp4, and mov files. With resolution no less than
                1920x1080, though on rare ocassions we can make exclusions and accept videos in lower resolution. Max
                filesize is 5GB. If you have files in different format/size contact us.</p>
            <p class="my-2">Media/Property releases should be submitted as jpeg files, and should be readable.</p>
            <h2 class="text-lg my-2 font-bold">USING SFTP FOR UPLOADING VIDEO</h2>
            <ol class="list list-decimal list-inside">
                <li class="mb-1">
                    Get you account approved for video submission, to do so contact us using live chat, or
                    at <a class="text-blue-500" href="maitlo:post@yayimages.com">post@yayimages.com</a>, Or fill out a
                    form in contributors
                    dashboard.
                </li>
                <li class="mb-1">
                    Login to our sftp server at <storng class="font-bold">sftp://intake.yayimages.com</storng> on port
                    22 using
                    your <strong class="font-bold">Username</strong> and password, drag and drop your
                    video files to get them uploaded.
                </li>
                <li class="mb-1">
                    If your videos have people in them your videos need to be media released, in some cases your videos
                    also need to be
                    property released to to do so upload your media/property releases into releases folder, you can
                    create the folder
                    yourself on sftp server.
                </li>
                <li class="mb-1">
                    Check <a class="text-blue-500"
                        href="https://contributors.yayimages.com/videos">contributors.yayimages.com/videos</a>
                    whether your files have been processed.
                </li>
                <li class="mb-1">
                    After you files were processed proceed with uploading meta information <strong
                        class="font-bold">csv</strong> file. see the sample file
                    attached <a class="text-blue-500" href="{{asset('sample/meta-sample.xlsx')}}">here</a>.
                    You can upload the csv files directly into into SFTP server.
                </li>
            </ol>
            <table class="my-5 text-xs table table-auto w-100" colpadding="1">
                <thead>
                    <tr class="border-b">
                        <th class="p-2 border">original_filename</th>
                        <th class="p-2 border">original_name</th>
                        <th class="p-2 border">title</th>
                        <th class="p-2 border">description</th>
                        <th class="p-2 border">keywords</th>
                        <th class="p-2 border">people</th>
                        <th class="p-2 border">number_of_people</th>
                        <th class="p-2 border">release_filenames</th>
                        <th class="p-2 border">releases</th>
                        <th class="p-2 border">editorial</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border">example-1.mov</td>
                        <td class="p-2 border">example-1</td>
                        <td class="p-2 border">Sample entry for video</td>
                        <td class="p-2 border">Sample entry for video description which further describes video</td>
                        <td class="p-2 border">video, sample, keywords</td>
                        <td class="p-2 border">yes</td>
                        <td class="p-2 border">1</td>
                        <td class="p-2 border">media-release.jpg, property-release.jpg</td>
                        <td class="p-2 border">media-release, property-release</td>
                        <td class="p-2 border">no</td>
                    </tr>
                    <tr class="text-gray-900">
                        <td class="p-2 border">Filename with extension <sup>(1)</sup></td>
                        <td class="p-2 border">Filename without extension <sup>(1)</sup></td>
                        <td class="p-2 border">Title of the video</td>
                        <td class="p-2 border">Free text description of the Footage</td>
                        <td class="p-2 border">Comma separated list of keywords, max 50</td>
                        <td class="p-2 border">yes/no whether there are people in video</td>
                        <td class="p-2 border">Number of people contained in the footage</td>
                        <td class="p-2 border">If you have a list with releases with extensions use this <sup>(2)</sup>
                        </td>
                        <td class="p-2 border">Provide just the names of releases without extensions. <sup>(2)</sup>
                        </td>
                        <td class="p-2 border">yes/no whether footage is editorial</td>
                    </tr>
                </tbody>
            </table>
            <ul class="list-none my-5 text-sm">
                <li class="mb-1">
                    <sup>(1)</sup> - Either original_filename or original_name needs to be provided
                </li>
                <li class="mb-1">
                    <sup>(2)</sup> - If People is marked as yes you need to provide either release_filenames or releases
                    needs to be provided
                </li>
                <li class="mb-1">
                    Always required fields original_filename or original_name, title, description, keywords
                </li>
                <li class="mb-1">
                    If people are marked one needs to mark number_of_people, and attach releases
                </li>
            </ul>
            <p class="mt-5">After uploading CSV your csv files will be processed any rows with mistakes will be ignored
                and meta information will
                not be updated. If you have repeated problems submitting the meta information file please contact us
                using live chat or
                <a class="text-blue-500" href="maitlo:post@yayimages.com">post@yayimages.com</a>.</p>
        </div>

    </div>
</body>

</html>