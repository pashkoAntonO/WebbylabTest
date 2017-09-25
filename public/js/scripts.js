function addField() {
    var fieldsStar = document.getElementById("star");
    var separate = document.getElementById("separate");

    var name = document.createElement('input');

    name.type = 'text';
    name.className = 'form-control';
    name.name = 'stars[]';
    name.placeholder = 'Имя фамилия';

    fieldsStar.insertBefore(name, separate);

    var br = document.createElement('br');

    fieldsStar.insertBefore(br, name);

}