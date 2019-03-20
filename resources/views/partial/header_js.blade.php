<script type="text/javascript">

    window.APPLICATION_USER_DATE_FORMAT = '{{ \Modules\Platform\Core\Helper\UserHelper::userJsDateFormat() }}';
    window.APPLICATION_USER_TIME_FORMAT = '{{ \Modules\Platform\Core\Helper\UserHelper::userJsTimeFormat() }}';
    window.APPLICATION_USER_LANGUAGE = '{{ app()->getLocale() }}';
    window.UID = '{{ Auth::user()->id }}';
    window.PUSHER_ACIVE = '{{config('broadcasting.connections.pusher.key') != '' ? 1 : 0}}';
    @if(\Modules\Platform\Core\Helper\UserHelper::userJsTimeFormat()  == 'HH:mm')
    window.APPLICATION_USER_TIME_FORMAT_24 = true;
    @else
    window.APPLICATION_USER_TIME_FORMAT_24 = false;
    @endif
    @if(config('bap.tags_allow_add_new'))
    window.APPLICATION_ALLOW_NEW_TAGS = true;
    @else
    window.APPLICATION_ALLOW_NEW_TAGS = false;
    @endif
</script>


@if(config('bap.google_ga'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_ga') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ config('bap.google_ga') }}');
    </script>
@endif