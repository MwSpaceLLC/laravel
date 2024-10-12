@if (session()->has('success'))
    <div
        style="z-index:99999;position: fixed; top: 20px; right: 20px; width: 400px; padding: 20px; background-color: #0f9d58; color: white;">
        <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Operazione completata</div>
        <ul style="margin-bottom: 10px;">
            <li>{{ session()->get('success') }}</li>
        </ul>
        <button type="button"
                style="background-color:transparent;text-transform:uppercase;color: white; border: none; font-weight: bold; cursor: pointer; float: right;"
                onclick="this.parentElement.style.display = 'none';">Chiudi
        </button>
    </div>
@endif

@if (isset($errors) && $errors->any())
    <div
        style="z-index:99999;position: fixed; top: 20px; right: 20px; width: 400px; padding: 20px; background-color: #DB4437; color: white;">
        <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Si è verificato un errore</div>
        <ul style="margin-bottom: 10px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button"
                style="background-color:transparent;text-transform:uppercase;color: white; border: none; font-weight: bold; cursor: pointer; float: right;"
                onclick="this.parentElement.style.display = 'none';">Chiudi
        </button>
    </div>
@endif
