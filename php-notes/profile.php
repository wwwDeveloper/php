<?php
session_start();
require 'check.php';
$data = $_SESSION['logged_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <title>My Notes</title>
</head>
<body>
<div class="container">
<div class="btn-logout">
    <button class="btn-item" onclick="logout();">LogOut</button>
</div>


<div onclick="createElms();" class="add_div">
<div class="add_img">
<img src="img/add.svg">
</div>
<span class="add_span">Add note</span>
</div>



<div class="main">
<ul id="notes_ul" reversed>    
</ul>
</div>


<script type="text/javascript">

function createElms(){
    CreateEl = new CreateElements(); 
}



class CreateElements{

#user_id = '<?php echo $data['user_id']; ?>';
currentDate = new Date();
key = "note_" + this.#user_id + "_" + this.currentDate.getTime();
notes_ul = document.getElementById("notes_ul");
note = this.note;
constructor(){
this.createLi();
this.createSpan();
this.createButtonDelete();
this.buttonDeleteImg();
this.createButtonSave();
this.editNote();
addNoteToDB(this.key, this.note);
}

createLi(){
this.notes_item = document.createElement('li');
this.notes_item.className = "notes_item";
this.notes_item.id = this.key;
this.notes_ul.prepend(this.notes_item);
}

createSpan(){
this.span_notes = document.createElement("span");
this.span_notes.textContent = "Add text:";
this.span_notes.classList.add('span_note');
this.notes_item.appendChild(this.span_notes);
this.note = this.span_notes.textContent;
}



 
createButtonDelete(){
this.button_delete = document.createElement('BUTTON');
this.button_delete.classList.add("btn-delete");
this.button_delete.id = "button_delete";
this.button_delete.onclick = () =>
{
    this.#deleteNote(this.key);
}
this.notes_item.appendChild(this.button_delete);
}

buttonDeleteImg(){
this.button_img= document.createElement('img');
this.button_img.className = "delete_img";
this.button_img.id = "img_delete";
this.button_img.setAttribute('src', 'img/delete.svg');
this.button_delete.appendChild(this.button_img);    
}


createButtonSave(){
this.save_button = document.createElement("BUTTON");
this.save_button.type = 'button';
this.save_button.className = "btn-save";
this.save_button.innerHTML = "Save"; 
this.save_button.onclick = () =>
{
    saveNote(this.key, this.note);   
}
this.notes_item.appendChild(this.save_button);
}

editNote(){

this.notes_item.addEventListener('dblclick', this.func = () =>
{   
    this.span = this.notes_item.firstElementChild;
    this.input = document.createElement('textarea');
    this.input.setAttribute('maxlength', '320');
    this.input.classList.add('span-input');    
    this.input.value = this.span.innerHTML;   
    this.span.innerHTML = "";
    this.span.appendChild(this.input);

    this.input.addEventListener('blur', () => 
    {
        this.span.innerHTML = this.input.value;
        
        this.note = this.input.value;        

        this.notes_item.addEventListener('dblclick', this.func);
    })
    this.notes_item.removeEventListener('dblclick', this.func);

})
}
#deleteNote(){
const request = new XMLHttpRequest();
const url = "delete.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("note_id="+ this.key);
request.onreadystatechange = () => {
if (request.readyState == 4 && request.status == 200) {
  this.#removeNoteFromDOM(); 
}       //if

};
}

#removeNoteFromDOM(){ 
	this.notes_item.parentNode.removeChild(this.notes_item);
}

}//end Class CreateElements


class LoadElements{

notes_ul = document.getElementById("notes_ul");

constructor(key, note){
this.key = key;
this.note = note;    
this.createLi(this.key);
this.createSpan(this.note);
this.createButtonDelete(this.key);
this.buttonDeleteImg();
this.createButtonSave(this.key, this.note);
this.editNote();
}

createLi(key){
this.notes_item = document.createElement('li');
this.notes_item.className = "notes_item";
this.notes_item.id = this.key;
this.notes_ul.appendChild(this.notes_item);
}

createSpan(note){
this.span_notes = document.createElement("span");
this.span_notes.textContent = this.note;
this.span_notes.classList.add('span_note');
this.notes_item.appendChild(this.span_notes);
}

createButtonDelete(key){
this.button_delete = document.createElement('BUTTON');
this.button_delete.classList.add("btn-delete");
this.button_delete.id = "button_delete";
this.button_delete.onclick = () =>
{
    this.#deleteNote(this.key);
}
this.notes_item.appendChild(this.button_delete);
}

buttonDeleteImg(){
this.button_img= document.createElement('img');
this.button_img.className = "delete_img";
this.button_img.id = "img_delete";
this.button_img.setAttribute('src', 'img/delete.svg');
this.button_delete.appendChild(this.button_img);    
}


createButtonSave(key, note){
this.save_button = document.createElement("BUTTON");
this.save_button.type = 'button';
this.save_button.className = "btn-save";
this.save_button.innerHTML = "Save"; 
this.save_button.onclick = () =>
{
    saveNote(this.key, this.note);   
}
this.notes_item.appendChild(this.save_button);
}

editNote(){

this.notes_item.addEventListener('dblclick', this.func = () =>
{  
    this.span = this.notes_item.firstElementChild;  

    this.input = document.createElement('textarea');
    this.input.setAttribute('maxlength', '320');
    this.input.classList.add('span-input');
    this.input.value = this.span.innerHTML; 
    this.span.innerHTML = "";
    this.span.appendChild(this.input);

    this.input.addEventListener('blur', () => 
    {
        this.span.innerHTML = this.input.value;
        
        this.note = this.input.value;        

        this.notes_item.addEventListener('dblclick', this.func);
    })
    this.notes_item.removeEventListener('dblclick', this.func);

})
}
#deleteNote(key){
const request = new XMLHttpRequest();
const url = "delete.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("note_id="+ this.key);
request.onreadystatechange = () => {
if (request.readyState == 4 && request.status == 200) {
  this.#removeNoteFromDOM(); 
}       //if

};
}

#removeNoteFromDOM(){ 
	this.notes_item.parentNode.removeChild(this.notes_item);
}
}// end LoadElements


function addNoteToDB(key, note){
let user_id = '<?php echo $data['user_id']; ?>';
let json = JSON.stringify({"note_id": key, "note": note, "user_id": user_id});   
const request = new XMLHttpRequest();
const url = "add.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("json="+json); 
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
}       //if
};
}

function saveNote(key, note){
let user_id = '<?php echo $data['user_id']; ?>';
let json = JSON.stringify({"note_id": key, "note": note, "user_id":user_id}); 
const request = new XMLHttpRequest();
const url = "update.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("json="+json);
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
}       //if
};
}


function getNotes(){
let user_id = '<?php echo $data['user_id']; ?>';
const request = new XMLHttpRequest();
const url = "main.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("get_notes="+ user_id); 
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
    let obj = JSON.parse(request.responseText);
    for (let key in obj) {   
    let loadNotes = new LoadElements(obj[key]['note_id'], obj[key]['note'])
  }       //if

}
};
};


getNotes();


function logout(){
const request = new XMLHttpRequest();
const url = "logout.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("logout="+"1"); 
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
    window.location.href = "index.php";
}       //if

};  
}

    </script>

    </div>
</body>
</html>