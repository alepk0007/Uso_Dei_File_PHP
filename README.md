### 📊 Registro Voti (Lettura File CSV in PHP)

Un'applicazione web leggera in PHP progettata per dimostrare l'estrazione, il filtraggio e l'elaborazione di dati da file strutturati (CSV). Il sistema simula il registro elettronico di una scuola, permettendo all'utente di interrogare un database testuale e calcolare medie statistiche.

#### 🚀 Funzionalità Principali

* **Lettura e Parsing del File:** Lo script accede al file locale `random-grades 1.csv` utilizzando la funzione `file()` con i flag `FILE_IGNORE_NEW_LINES` e `FILE_SKIP_EMPTY_LINES` per garantire una lettura pulita e priva di artefatti visivi. Successivamente, la funzione `str_getcsv()` converte ogni riga in un array strutturato.


* **Motore di Filtraggio Flessibile:** L'interfaccia HTML fornisce un modulo `GET` per filtrare i dati per Cognome, Nome, Classe e Materia. Il filtraggio lato server utilizza `strcasecmp()` per garantire ricerche *case-insensitive* (ignora maiuscole e minuscole), offrendo un'esperienza utente tollerante agli errori di digitazione.


* **Calcolo Aggregato (Media):** Il sistema itera sui record che soddisfano i criteri di ricerca (verificati tramite l'operatore AND `&&`), sommando i voti convertiti in virgola mobile (`floatval`). Al termine del ciclo, il programma restituisce la media matematica arrotondata (tramite `round()`) del set di dati filtrato.


* **Sanificazione dell'Input (XSS Protection):** Prima di stampare in pagina i valori estratti dal CSV o i dati inseriti dall'utente nel form, lo script utilizza rigorosamente `htmlspecialchars()` per prevenire vulnerabilità di tipo Cross-Site Scripting (XSS).



#### 🛠 Tecnologie Utilizzate

* **Backend:** PHP (gestione I/O file, elaborazione stringhe, logica algoritmica iterativa).


* **Frontend:** HTML e CSS nativo per la struttura tabellare e l'impaginazione del modulo di ricerca.


* **Origine Dati:** CSV (Comma-Separated Values). (Il progetto include un file di test generato casualmente, `random-grades 1.csv`, con 10.341 record di valutazioni).



#### ⚙️ Come testare il progetto

1. Assicurati di disporre di un server web locale con supporto PHP (come XAMPP, MAMP o il server PHP integrato).
2. Clona questa repository e inserisci i file in una cartella accessibile dal server (es. `htdocs`).
3. Verifica che il file `random-grades 1.csv` si trovi nella stessa cartella dello script PHP principale (o modifica la variabile `$csvFile` nel codice per puntare al percorso corretto).


4. Apri il browser e naviga all'indirizzo dello script.
5. Inserisci i criteri di ricerca nel modulo (ad esempio "Matematica" nella Materia) e clicca su "Filtra" per visualizzare i risultati e la media calcolata.




