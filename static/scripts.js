const DEFAULT_FORM = `
<div class="form-group">
                <label for="firstNameLastName">ФИО</label>
                <input type="email" class="form-control" id="firstNameLastName" aria-describedby="emailHelp" placeholder="ФИО">
                <small id="emailHelp" class="form-text text-muted">Только русские символы.</small>
            </div>
            <div class="form-group">
                <label for="INN">ИНН</label>
                <input type="text" class="form-control" id="INN" placeholder="ИНН">
            </div>`

const PHYSFACE_FORM = `<div class="form-group">
<label for="Birthday">Дата рождения</label>
<input type="date" class="form-control" id="Birthday"><br>
</div>

<div class="form-group">
<h3>Паспортные данные</h3>
<label>Серия</label>
<input type="text" class="form-control" id="passportFirst" placeholder="Серия">
<label>Номер</label>
<input type="text" class="form-control" id="passportSecond" placeholder="Номер">
<label>Дата выдачи</label>
<input type="date" class="form-control" id="passportDate">
</div><br>`

const URFACE_FORM = `<h1>WIP</h1>`

document.getElementById("physface").onclick = () => {
    console.log(1);
    document.getElementById("face-container").innerHTML = DEFAULT_FORM + PHYSFACE_FORM;
}

document.getElementById("urface").onclick = () => {
    document.getElementById("face-container").innerHTML = DEFAULT_FORM + URFACE_FORM;
}