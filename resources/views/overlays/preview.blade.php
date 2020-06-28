<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Preview</title>

    <style>
        .slide {
            background-color: rgba(0, 0, 0, 0.9);
            position: absolute;
            display: flex;
            align-items: center;
            font-family: Roboto, sans-serif;
            font-weight: 300;
        }

        .white {
            background-color: #FFF;
        }

        .center {
            justify-content: center;
        }

        .lower {
            width: 100%;
            bottom: 0;
            align-items: center;
            padding: 20px 70px;
            min-height: 200px;
        }

        .full {
            padding: 20px 80px;
            width: 100%;
            top: 15%;
            bottom: 15%;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .full strong {
            display: inline-block;
            margin: 10px 0;
        }

        .large {
            font-size: 130%;
        }

        .half {
            height: 100%;
            padding: 0 50px;
        }

        .right {
            left: 50%;
            right: 0;
        }

        strong {
            font-weight: 800;
        }

        .blank {
            background-color: rgba(0,0,0,0.1);
            width: 1px;
            height: 1px;
        }
    </style>
</head>
<body class="text-gray-100 text-2xl">
<div id="app" class="fixed inset-0 flex flex-col">
    <div class="slide" class="{{ $css }}">
        <div class="inner">{!! $content !!}</div>
    </div>
</div>
</body>
</html>
