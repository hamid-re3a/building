<!-- resources/views/command.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Run Artisan Commands</title>
</head>
<body>
<h1>Run Artisan Command</h1>
<form method="POST" action="{{ route('command.run') }}">
    @csrf
    <label for="command">Command:</label>
    <input type="text" id="command" name="command" placeholder="migrate" value="{{ $command ?? '' }}" required>
    <button type="submit">Run</button>
</form>

@if (isset($output))
    <h2>Output:</h2>
    <pre>{{ $output }}</pre>
@endif
</body>
</html>
