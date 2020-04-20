@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

Your request for Video Contributor status, has been successfully approved by one of our team members! 

The videos you submit will be sold individually, as follow:
- Single Sales (on-demand priced by quality, per clip)
- SD: $49
- HD: $59
- 4K: $149

## SUPPORTED FORMATS AND LIMITATIONS
Currently we support uploading of mp4, and mov files. With resolution no less than 1920x1080. Max filesize is 5GB. If
you have files in different format/size contact us.

Media/Property releases should be submitted as jpeg files, and should be readable.

## USING SFTP FOR UPLOADING VIDEO
1. Get your account approved for video submission, by filling out the form in your contributor dashboard.
2. Login to our sftp server at sftp://intake.yayimages.com using your yayimages contributor portal credentials, drag and
drop your video files to get them uploaded.
3. If your videos have people in them your videos need to be media released, in some cases your videos also need to be
property released to to do so upload your media/property releases into releases folder, you can create the folder
yourself on sftp server.
4. Check contributors.yayimages.com/videos whether your files have been processed.
5. After you files were processed proceed with uploading meta information csv file. see the sample file
attached [here]({{asset('meta-sample.xlsx')}})

Please visit [{{url('/')}}]({{url('/')}}) to learn more & being uploading.  

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
'into your web browser: [:actionURL](:actionURL)',
[
'actionText' => $actionText,
'actionURL' => $actionUrl,
]
)
@endslot
@endisset

Thanks,<br>
{{ config('app.name') }}
@endcomponent