document.getElementById("individualRadio").onclick = () => {
    document.getElementById("face-ur").hidden = true;
    document.getElementById("face-phys").hidden = false;
}

document.getElementById("entityRadio").onclick = () => {
    document.getElementById("face-ur").hidden = false;
    document.getElementById("face-phys").hidden = true;
}

document.getElementById("next").onclick = () => {
    console.log("Переход на второй шаг...");

    const type = document.getElementById("face-ur").hidden ? "individual" : "entity";

    let isFieldsRight = true;

    switch (type) {
        case "individual": {
            console.log("Проверка полей физического лица...")
            break;
        }

        case "entity": {
            console.log("Проверка полей юр лица...")
            break;
        }
    }

    if (!isFieldsRight)
        return;

    invokeSecondStep(type);
}

function invokeSecondStep() {
    document.getElementById("face-container").hidden = true;
    document.getElementById("product-container").hidden = false;
    document.getElementById("next").hidden = true;

    document.getElementById("firstStep").classList = "page-item disabled"
    document.getElementById("secondStep").classList = "page-item active"
}

function invokeFirstStep() {
    document.getElementById("face-container").hidden = false;
    document.getElementById("product-container").hidden = true;
    document.getElementById("next").hidden = false;

    document.getElementById("firstStep").classList = "page-item active"
    document.getElementById("secondStep").classList = "page-item disabled"
}

document.getElementById("back").onclick = invokeFirstStep;

document.getElementById("creditRadio").onclick = () => {
    document.getElementById("deposit-container").hidden = true;
    document.getElementById("credit-container").hidden = false;
}

document.getElementById("depositRadio").onclick = () => {
    document.getElementById("deposit-container").hidden = false;
    document.getElementById("credit-container").hidden = true;
}