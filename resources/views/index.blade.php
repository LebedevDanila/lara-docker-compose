<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallpapers</title>
    <meta name="description" content="description" />
    <meta name="keywords" content="keywords" />
    <link rel="stylesheet" href="/static/css/index.css" />
</head>
<body>
<div class="root">
    {{ view('components.header', ['data' => $data]) }}
    {{ view("pages.{$data['view_file']}", $data) }}
    {{ view('components.footer', ['data' => $data]) }}
</div>
<script type="text/javascript">
    const APP = {cdn: "<?=config('constants.cdn.url')?>"};
</script>
<script type="text/javascript" src="/static/js/libs/jquery.js"></script>
<script type="text/javascript" src="/static/js/index.js"></script>
</body>
</html>