<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer les Employés</title>
</head>
<body>
    <h1>Importer des Employés</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulaire d'importation -->
    <form action="{{ route('import.employes') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Choisissez un fichier Excel :</label>
        <input type="file" name="file" id="file" required>
        <button type="submit">Importer</button>
    </form>

</body>
</html>
