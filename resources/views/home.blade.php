<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
              integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    </head>
    <body>
        <div class="col">
            <form action="/" method="get">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="column"> Column </label>
                        <select id="column" class="form-control form-control-sm" name="column">
                            <option selected> author </option>
                            <option> title </option>
                        </select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="way"> Way </label>
                        <select id="way" class="form-control form-control-sm" name="way">
                            <option selected> asc </option>
                            <option> desc </option>
                        </select>
                    </div>
                    <div class="form-group col-md-2 d-flex justify-content-center align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary w-100"> Sort </button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col"> # </th>
                    <th scope="col"> Publication date </th>
                    <th scope="col"> Title </th>
                    <th scope="col"> Author </th>
                    <th scope="col"> Tags </th>
                </tr>
            </thead>
            <tbody>
                @if(count($articles))
                    @foreach($articles as $index => $article)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $article['published_at'] }}</td>
                        <td>
                            <a href="{{env('PARSE_DOMAIN') . $article['link']}}" target="_blank">
                                {{ $article['title'] }}
                            </a>
                        </td>
                        <td>{{ $article['author'] }}</td>
                        <td>
                            @foreach($article['tags'] as $index => $tag)
                                @if ($index) , @endif {{ $tag['name'] }}
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="6" class="text-center">
                            <form method="get" action="/parse">
                                <div> Data base empty </div>
                                <button action="submit" class="btn badge badge-success"> load articles </button>
                            </form>
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </body>
</html>
