<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>
</head>
<body>
    <input type="color" name="colorpicker" id="colorPicker">

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        let colorPicker = document.getElementById('colorPicker');
        colorPicker.addEventListener('input', async function() {

            axios.post("{{route('fire.public.event')}}", {
                color: colorPicker.value
            }, {
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            })
        });
    </script>
</body>
</html>
