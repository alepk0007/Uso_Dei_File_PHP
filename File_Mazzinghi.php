<?php
// Nome del file CSV
$csvFile = "random-grades 1.csv";

// Controllo se il file esiste
if (!file_exists($csvFile)) {
    die("<strong>Errore:</strong> il file '$csvFile' non è stato trovato.");
}

// Leggo le righe del file (skip righe vuote)
$righeCSV = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Rimuovo l'intestazione (se presente)
array_shift($righeCSV);

// Prendo i filtri dal form (GET)
$cognome = isset($_GET['cognome']) ? trim($_GET['cognome']) : '';
$nome    = isset($_GET['nome'])    ? trim($_GET['nome'])    : '';
$classe  = isset($_GET['classe'])  ? trim($_GET['classe'])  : '';
$materia = isset($_GET['materia']) ? trim($_GET['materia']) : '';

// Risultati e calcolo media
$risultati = [];
$sommaVoti = 0.0;
$contaVoti = 0;

foreach ($righeCSV as $riga) {
    $dati = str_getcsv($riga);
    if (count($dati) < 5) continue;

    list($cog, $nom, $cla, $mat, $votoRaw) = $dati;
    $voto = floatval($votoRaw);

    // Filtri (se campo vuoto => ignoro il filtro)
    $okCognome = ($cognome === '' || strcasecmp($cognome, trim($cog)) === 0);
    $okNome    = ($nome === ''    || strcasecmp($nome, trim($nom)) === 0);
    $okClasse  = ($classe === ''  || strcasecmp($classe, trim($cla)) === 0);
    $okMateria = ($materia === '' || strcasecmp($materia, trim($mat)) === 0);

    if ($okCognome && $okNome && $okClasse && $okMateria) {
        $risultati[] = [
                'cognome' => trim($cog),
                'nome'    => trim($nom),
                'classe'  => trim($cla),
                'materia' => trim($mat),
                'voto'    => $voto
        ];
        $sommaVoti += $voto;
        $contaVoti++;
    }
}

$media = $contaVoti > 0 ? $sommaVoti / $contaVoti : 0;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registro Voti - Ricerca</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f6f8fb; padding:20px; }
        form, table { background:#fff; padding:12px; border-radius:6px; }
        table { width:100%; border-collapse:collapse; margin-top:12px; }
        th, td { border:1px solid #ddd; padding:6px; text-align:center; }
        input[type="text"] { width:95%; padding:6px; margin:4px 0; }
        input[type="submit"] { padding:8px 12px; margin-top:8px; }
    </style>
</head>
<body>
<h1>📘 Cerca voti</h1>

<form method="get">
    <label>Cognome:</label><br>
    <input type="text" name="cognome" value="<?php echo htmlspecialchars($cognome); ?>"><br>

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>"><br>

    <label>Classe:</label><br>
    <input type="text" name="classe" value="<?php echo htmlspecialchars($classe); ?>"><br>

    <label>Materia:</label><br>
    <input type="text" name="materia" value="<?php echo htmlspecialchars($materia); ?>"><br>

    <input type="submit" value="Filtra">
</form>

<h2>Risultati</h2>
<table>
    <tr>
        <th>Cognome</th>
        <th>Nome</th>
        <th>Classe</th>
        <th>Materia</th>
        <th>Voto</th>
    </tr>

    <?php if ($contaVoti > 0): ?>
        <?php foreach ($risultati as $r): ?>
            <tr>
                <td><?php echo htmlspecialchars($r['cognome']); ?></td>
                <td><?php echo htmlspecialchars($r['nome']); ?></td>
                <td><?php echo htmlspecialchars($r['classe']); ?></td>
                <td><?php echo htmlspecialchars($r['materia']); ?></td>
                <td><?php echo htmlspecialchars($r['voto']); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">Nessun voto trovato</td></tr>
    <?php endif; ?>
</table>

<p><strong>Media:</strong> <?php echo $contaVoti>0 ? round($media,2) : '—'; ?></p>
</body>
</html>