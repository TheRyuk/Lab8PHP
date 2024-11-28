const categoryTableBody=document.querySelector('#categoriesTable tbody');
const commandTableBody=document.querySelector('#commandsTable tbody');
const exampleTableBody=document.querySelector('#examplesTable tbody');

const categoryForm=document.getElementById('categoryForm');
const commandForm=document.getElementById('commandForm');
const exampleForm=document.getElementById('exampleForm');

const categoryRow=document.getElementById('categoryRow');
const commandRow=document.getElementById('commandRow');
const exampleRow=document.getElementById('exampleRow');

const navMenu=document.getElementById('navMenu');
const loginForm=document.getElementById('loginForm');
const categoriesSelect=document.getElementById('categoriesSelect');
const examplesSelect=document.getElementById('examplesSelect');
let categoryData={}
let commandData={}
let exampleData={}

fetch('https://localhost/PHP/api/profile')
    .then((response) => response.json())
    .then((data) => {
        if (data['login']){
            navMenu.style.display="flex";
            loginForm.style.display="none";
        }else{
            loginForm.style.display="block";
            navMenu.style.display="none";
            categoryRow.style.display="none";
            commandRow.style.display="none";
            exampleRow.style.display="none";
        }   
    })
        .catch(console.error);

function displayCategories(){
    fetch('https://localhost/PHP/api/categories')
    .then((response) => response.json())
    .then((data) => {
        categoryData=data;
        let content=``;
        let inputContent=``;
        for(i=0;i<data.length;i++){
            content+=`<tr>
            <td>`+data[i]['id']+`</td>
            <td>`+data[i]['name']+`</td>
            <td>`+data[i]['description']+`</td>
            <td><a href="#" class="edit-category" data-id="`+data[i]['id']+`">Редагувати</a>
            <a href="#" class="delete-category" data-id="`+data[i]['id']+`">Видалити</a></td>        
            </tr>`
            inputContent+=`<option value="`+data[i]['id']+`">`+data[i]['name']+`</option>`
        }
        categoryTableBody.innerHTML=content;
        categoriesSelect.innerHTML=inputContent;        
    })
        .catch(console.error);
}
displayCategories();

function displayCommands(query){
    let url="https://localhost/PHP/api/commands";
    if(query!==null){
        url="https://localhost/PHP/api/commands?query="+query;
    }
    fetch(url)
    .then((response) => response.json())
    .then((data) => {
   
        commandData=data;
        let content=``;
        for(i=0;i<data.length;i++){
            content+=`<tr>
            <td>`+data[i]['id']+`</td>
            <td>`+data[i]['command_name']+`</td>
            <td>`+data[i]['description']+`</td>
            <td>`+data[i]['category_id']+`</td>
            <td><a href="#" class="edit-command" data-id="`+data[i]['id']+`">Редагувати</a>
            <a href="#" class="delete-command" data-id="`+data[i]['id']+`">Видалити</a></td>        
            </tr>`
        }
        commandTableBody.innerHTML=content;      
    })
        .catch(console.error);
}
displayCommands(null);

function displayExamples() {
    fetch('https://localhost/PHP/api/examples')
        .then((response) => response.json())
        .then((data) => {
            exampleData = data;
            let content = ``;
            let inputContent=``;
            for (i = 0; i < data.length; i++) {
                content += `<tr>
                    <td>${data[i]['id']}</td>
                    <td>${data[i]['command_id']}</td>
                    <td>${data[i]['example_code']}</td>
                    <td>${data[i]['description']}</td>
                    <td>
                        <a href="#" class="edit-example" data-id="${data[i]['id']}">Редагувати</a>
                        <a href="#" class="delete-example" data-id="${data[i]['id']}">Видалити</a>
                    </td>
                </tr>`
                inputContent+=`<option value="`+data[i]['id']+`">`+data[i]['command_id']+`</option>`;
            }
            exampleTableBody.innerHTML = content;
            examplesSelect.innerHTML=inputContent;
        })
        .catch(console.error);
}
displayExamples();

document.addEventListener('submit', function(e) {
    if(e.target.id=="categoryForm"){
        e.preventDefault();
        let formId=document.querySelector('#categoryForm input[name="itemid"]').value;
        let formName=document.querySelector('#categoryForm input[name="name"]').value;
        let formDescription=document.querySelector('#categoryForm input[name="description"]').value;
        if(formId==""){
            let data=JSON.stringify({"name":formName,"description":formDescription});
            fetch("https://localhost/PHP/api/categories",
                {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCategories();
                categoryForm.reset();
                document.querySelector('#categoryForm input[name="itemid"]').value="";
            });
        } else{
            let data=JSON.stringify({"id":formId,"name":formName,"description":formDescription});
            fetch("https://localhost/PHP/api/categories",
                {
                    method: "PUT",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCategories();
                categoryForm.reset();
                document.querySelector('#categoryForm input[name="itemid"]').value="";
                });
            }   
        }
        
    if(e.target.id=="commandForm"){
        e.preventDefault();
        let formId=document.querySelector('#commandForm input[name="itemid"]').value;
        let formName=document.querySelector('#commandForm input[name="command_name"]').value;
        let formDescription=document.querySelector('#commandForm input[name="description"]').value;
        let formCategoryName=document.querySelector('#commandForm select[name="category_id"]').value;
        
        if(formId==""){
            let data=JSON.stringify({"command_name":formName,"description":formDescription,"category_id":formCategoryName});
            fetch("https://localhost/PHP/api/commands",
                {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCommands(null);
                commandForm.reset();
                document.querySelector('#commandForm input[name="itemid"]').value="";
            });
        } else{
            let data=JSON.stringify({"id":formId,"command_name":formName,"description":formDescription,"category_id":formCategoryName});
            fetch("https://localhost/PHP/api/commands",
                {
                    method: "PUT",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCommands(null);
                commandForm.reset();
                document.querySelector('#commandForm input[name="itemid"]').value="";
                });
            }   
        }


        if (e.target.id === "exampleForm") {
            e.preventDefault();
            let formId = document.querySelector('#exampleForm input[name="itemid"]').value;
            let formCommandId = document.querySelector('#exampleForm select[name="command_id"]').value;
            let formExampleCode = document.querySelector('#exampleForm input[name="example_code"]').value;
            let formDescription = document.querySelector('#exampleForm input[name="description"]').value;
    
            if (formId === "") {
                
                let data = JSON.stringify({
                    "command_id": formCommandId,
                    "example_code": formExampleCode,
                    "description": formDescription
                });
                fetch("https://localhost/PHP/api/examples", {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
                .then(res => res.json())
                .then(data => {
                    displayExamples();
                    exampleForm.reset();
                    document.querySelector('#exampleForm input[name="itemid"]').value = "";
                });
            } else {
                
                let data = JSON.stringify({
                    "id": formId,
                    "command_id": formCommandId,
                    "example_code": formExampleCode,
                    "description": formDescription
                });
                fetch("https://localhost/PHP/api/examples", {
                    method: "PUT",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
                .then(res => res.json())
                .then(data => {
                    displayExamples();
                    exampleForm.reset();
                    document.querySelector('#exampleForm input[name="itemid"]').value = "";
                });
            }
        }

            if(e.target.id=="loginForm"){
                e.preventDefault();
                let formLogin=document.querySelector('#loginForm input[name="login"]').value;
                let formPass=document.querySelector('#loginForm input[name="password"]').value;
                    let data=JSON.stringify({"login":formLogin,"password":formPass});
                    fetch("https://localhost/PHP/api/profile",
                        {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json, text/plain, */*',
                                'Content-Type': 'application/json'
                            },
                            body: data
                        })
                    .then(function(res){ return res.json(); })
                    .then(function(data){ 
                        if (data['login']){
                            navMenu.style.display="flex";
                            loginForm.style.display="none";
                        }else{
                            loginForm.style.display="block";
                            navMenu.style.display="none";
                            categoryRow.style.display="none";
                            parameterRow.style.display="none";
                            backpackRow.style.display="none";
                        }   
                    });
                
            }
            if(e.target.id=="searchForm"){
                e.preventDefault();
                let formQuery=document.querySelector('#searchForm input[name="query"]').value;
                displayCommands(formQuery);
            }
    }
    , false);

document.addEventListener('click', function(e) {
        if(e.target.classList.contains('edit-category')){
            e.preventDefault();
            for(i=0;i<categoryData.length;i++){
                if(categoryData[i]['id']==e.target.getAttribute('data-id')){
                    let itemData=categoryData[i];
                    document.querySelector('#categoryForm input[name="itemid"]').value=itemData['id'];
                    document.querySelector('#categoryForm input[name="name"]').value=itemData['name'];
                    document.querySelector('#categoryForm input[name="description"]').value=itemData['description'];
                }
            }
        } else if(e.target.classList.contains('delete-category')){
            e.preventDefault();
            let data=JSON.stringify({"id":e.target.getAttribute('data-id')})
            fetch("https://localhost/PHP/api/categories",
                {
                    method: "DELETE",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCategories();
            });
        }

        if(e.target.classList.contains('edit-command')){
            e.preventDefault();
            for(i=0;i<commandData.length;i++){
                if(commandData[i]['id']==e.target.getAttribute('data-id')){
                    let itemData=commandData[i];
                    document.querySelector('#commandForm input[name="itemid"]').value=itemData['id'];
                    document.querySelector('#commandForm input[name="command_name"]').value=itemData['command_name'];
                    document.querySelector('#commandForm input[name="description"]').value=itemData['description'];
                    document.querySelector('#commandForm select[name="category_id"]').value=itemData['category_id'];
                }
            }
        } else if(e.target.classList.contains('delete-command')){
            e.preventDefault();
            let data=JSON.stringify({"id":e.target.getAttribute('data-id')})
            fetch("https://localhost/PHP/api/commands",
                {
                    method: "DELETE",
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: data
                })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCommands(null);
            });
        }
 
        if (e.target.classList.contains('edit-example')) {
            e.preventDefault();
            for (i = 0; i < exampleData.length; i++) {
                if (exampleData[i]['id'] == e.target.getAttribute('data-id')) {
                    let itemData = exampleData[i];
                    document.querySelector('#exampleForm input[name="itemid"]').value = itemData['id'];
                    document.querySelector('#exampleForm select[name="command_id"]').value = itemData['command_id'];
                    document.querySelector('#exampleForm input[name="example_code"]').value = itemData['example_code'];
                    document.querySelector('#exampleForm input[name="description"]').value = itemData['description'];
                }
            }
        } else if (e.target.classList.contains('delete-example')) {
            e.preventDefault();
            let data = JSON.stringify({ "id": e.target.getAttribute('data-id') });
            fetch("https://localhost/PHP/api/examples", {
                method: "DELETE",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(res => res.json())
            .then(data => {
                displayExamples();
            });
        }
    
        
        else if(e.target.id=="categoriesButton"){
            e.preventDefault();
            categoryRow.style.display="flex";
            commandRow.style.display="none";
            exampleRow.style.display="none";
        } else if(e.target.id=="commandsButton"){
            e.preventDefault();
            categoryRow.style.display="none";
            commandRow.style.display="flex";
            exampleRow.style.display="none";
        } else if(e.target.id=="examplesButton"){
            e.preventDefault();
            categoryRow.style.display="none";
            commandRow.style.display="none";
            exampleRow.style.display="flex";
        }else if(e.target.id=="logoutButton"){
            e.preventDefault();
            fetch("https://localhost/PHP/api/profile?action=logout")
    .then(res => {
        if (res.ok) {
            return res.text(); // Навіть якщо відповідь порожня
        } else {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
    })
    .then(data => {
        loginForm.style.display = "block";
        navMenu.style.display = "none";
        categoryRow.style.display = "none";
        commandRow.style.display = "none";
        exampleRow.style.display = "none";
    })
    .catch(err => console.error("Fetch error:", err));

    }}, false);