<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Import Départements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light py-5">
<div class="container">
    <h2 class="mb-4">Importer des Départements</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departements.import') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="file" class="form-label">Fichier Excel (.xlsx, .csv)</label>
            <input type="file" name="file" id="file" class="form-control" required accept=".xlsx,.xls,.csv">
        </div>

        <button type="submit" class="btn btn-primary">Importer</button>
    </form>
</div>
</body>
</html>
