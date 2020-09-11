<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <td><b><i>Question</i></b></td>
                    <td><b><i>Value</i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach($docs as $doc)
                    <tr>
                        <td>{{$doc->title}}</td>
                        <td>{{$doc->value}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
