function escribano(){
    let modalEl = document.getElementById('modalEs')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}
function profesional(){
    let modalEl = document.getElementById('modalProf')
    let modal= bootstrap.Modal.getOrCreateInstance(modalEl)
    modal.show();
}

function saveProfesional(){
    let tr = document.createElement('tr')
    let pro = document.getElementById('profesional')
    let car = document.getElementById('caracter')
    tr.innerHTML = '<td hidden>'+ pro.value +'</td>' +'<td>'+ pro.options[pro.selectedIndex].text +'</td>' + '<td hidden>'+ car.value +'</td>'+ '<td>'+ car.options[car.selectedIndex].text +'</td>'
    document.getElementById('profbody').appendChild(tr)
    document.getElementById('tableprof').removeAttribute('hidden')
}