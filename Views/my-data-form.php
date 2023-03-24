<!-- Nome -->
<div class="form-group">
    <label class="platinum mt-2" for="name">Nome:</label>
    <input type="text" class="form-control" id="name" placeholder="Inserisci il tuo nome" required>
    <small id="errorName" class="text-danger" hidden>Inserire un nome.</small>
</div>
<!-- Cognome -->
<div class="form-group">
    <label class="platinum mt-2" for="surname">Cognome:</label>
    <input type="text" class="form-control" id="surname" placeholder="Inserisci il tuo cognome" required>
    <small id="errorSurname" class="text-danger" hidden>Inserire un cognome.</small>
</div>
<!-- Email -->
<div class="form-group">
    <label class="platinum mt-2" for="email">Email:</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
    <small id="errorEmail" class="text-danger" hidden>L'email deve avere un formato corretto.</small>
    <small id="emailHelp" class="form-text text-muted">La tua email sarà lo username per l'accesso.</small>
</div>
<!-- Ruolo -->
<div class="form-check mt-2">
    <label class="platinum">Ruolo:</label><br>
    <input class="role" type="radio" id="buyer" name="role" value="Compratore" />
    <label for="buyer" class="platinum">Desidero acquistare</label><br>
    <input class="role" type="radio" id="seller" name="role" value="Compratore e venditore" />
    <label for="seller" class="platinum">Desidero acquistare e vendere</label>
</div>