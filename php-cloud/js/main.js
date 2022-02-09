
const vms_array = {};

function createEl(name, vapp, lease, state_vm = vms_array[vmid], vmid, vappid){  

let table = document.querySelector("tbody");
let new_tr = document.createElement('tr');
new_tr.className = "table-item";
table.append(new_tr);

let td_vname = document.createElement('td');
td_vname.className = "col-vmname"
td_vname.textContent = name;
new_tr.appendChild(td_vname);


let td_vappname = document.createElement('td');
td_vappname.className = "col-vappname";
td_vappname.textContent = vapp;
new_tr.appendChild(td_vappname);


let td_date = document.createElement('td');
td_date.classList.add("col-date");
td_date.id = vappid+'_ls';
td_date.textContent = lease;
new_tr.appendChild(td_date);

let td_select = document.createElement('td');
td_select.className = "col-select";
new_tr.appendChild(td_select);

let form_select = document.createElement('form');
form_select.className = "form-select";
td_select.appendChild(form_select);

let input_select = document.createElement('input');
input_select.className = "select-input";
input_select.setAttribute('type', 'text');
input_select.setAttribute('name', 'select-lease');
input_select.setAttribute('list', 'select-list');
input_select.setAttribute('placeholder', 'expires date');
form_select.appendChild(input_select);

let button_save = document.createElement('BUTTON');
button_save.type = 'button';
button_save.setAttribute('name', vappid);
button_save.className = "btn-save";
button_save.id = vmid+"_btns";
button_save.textContent = "SAVE";
form_select.appendChild(button_save);
button_save.onclick = function()
{
 renewlease(vappid, input_select.value);
 input_select.value="";
}

let list_select = document.createElement('datalist');
list_select.id = "select-list";
list_select.className = "select-list";
form_select.appendChild(list_select);

let option_select_1 = document.createElement('option');
option_select_1.className = "select-value";
option_select_1.setAttribute('value', 30);
list_select.appendChild(option_select_1);

let option_select_2 = document.createElement('option');
option_select_2.className = "select-value";
option_select_2.setAttribute('value', 60);
list_select.appendChild(option_select_2);

let option_select_3 = document.createElement('option');
option_select_3.className = "select-value";
option_select_3.setAttribute('value', "Never Expires");
list_select.appendChild(option_select_3);


let td_state = document.createElement('td');
td_state.className = "col-state";
new_tr.appendChild(td_state);

let span_state = document.createElement('span');
span_state.id = vmid+"_state";
if(state_vm == "ON"){   
    span_state.classList.add('state-on');
}else if(state_vm == "OFF"){    
    span_state.classList.add('state-off');
}

span_state.textContent = state_vm;
td_state.appendChild(span_state)


let td_button = document.createElement('td');
td_button.className = "col-button";
new_tr.appendChild(td_button);
    let power_button = document.createElement("BUTTON");
power_button.type = 'button';
power_button.className = "btn-item";
power_button.id = vmid+"_button";
if(state_vm == "ON"){
    power_button.innerHTML = "POWER OFF";   
}else if(state_vm == "OFF"){
    power_button.innerHTML = "POWER ON";
}else{power_button.innerHTML = "?"}

power_button.onclick = function()
{
 power_manage(vmid); 
}
td_button.appendChild(power_button);

}; // createEl();

function getElements(){
let loader = document.getElementById("loader");
loader.classList.add('loader');

const request = new XMLHttpRequest();
const url = "vms.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("vmlist=" + "get_json"); 
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
    
     var obj = JSON.parse(request.responseText);
        for (let key in obj) {
        vms_array[obj[key]['id']] = obj[key]['status'];  
      
        createEl(key, obj[key]['containerName'], obj[key]['lease'], obj[key]['status'], obj[key]['id'], obj[key]['vappid']);
        
        loader.classList.remove('loader');
        };

      }       //if
      else{
        loader.classList.add('loader');
      
      }

   };

};

getElements();


function renewlease(vappid, input_value){

const request = new XMLHttpRequest();
const url = "include/change_lease.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
request.send("renew_lease=" + vappid + "," + input_value); 
console.log("renew_lease=" + vappid + "," + input_value);
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
  
    lease_state = document.getElementById(vappid+'_ls');
 
    lease_state.textContent = request.responseText;
 
}       //if

};

};


function power_manage(vmid){
    if(vms_array[vmid] == "OFF"){
     power_on(vmid);
    }
    else{       
    power_off(vmid);
    }
};//manage_power()


function power_on(vmid){
const request = new XMLHttpRequest();
const url = "vms.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
const header = request.getAllResponseHeaders();
request.send('vm_id_on='+ vmid);
request.onreadystatechange = function () 
{
if (request.readyState === 4 && request.status === 200) 
{
    vms_array[vmid] = "ON";
    
    status_state = document.getElementById(vmid+"_state");    
    status_state.textContent = "ON";
    status_state.classList.remove("state-off");
    status_state.classList.add("state-on"); 

    button = document.getElementById(vmid+"_button");   
    button.innerHTML = "POWER OFF";


}

};
};

function power_off(vmid){
const request = new XMLHttpRequest();
const url = "vms.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
const header = request.getAllResponseHeaders();
request.send('vm_id_off='+ vmid);
request.onreadystatechange = function () 
{
if (request.readyState === 4 && request.status === 200) 
{
    vms_array[vmid] = "OFF";
  
    status_state = document.getElementById(vmid+"_state");
    status_state.classList.remove("state-on");
    status_state.classList.add("state-off");    
    status_state.textContent = "OFF";  

    button = document.getElementById(vmid+"_button");   
    button.innerHTML = "POWER ON";


}

};
}

function logout(){
const request = new XMLHttpRequest();
const url = "logout.php";
request.open('POST', url);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
const header = request.getAllResponseHeaders();
request.send('logout='+ '1');
request.onreadystatechange = function () 
{
if (request.readyState === 4 && request.status === 200) 
{    
    window.location.href = "index.php";
}

}; 
}
