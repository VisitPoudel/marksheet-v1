<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table, th, td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <div>
        Marksheet of {{$student->full_name}}
    </div>
    <div>
        
        Percentage: {{round($percentage, 2)}}%
    </div>

    <table class="table">
        <thead>
          <tr>
            <th scope="col">S.N</th>
            <th scope="col">Subject</th>
            <th scope="col">Marks</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($marks as $mark)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{$mark->subject->name}}</td>
                  <td>{{$mark->marks}}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
</body>
</html>