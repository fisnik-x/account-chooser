(function() {

    const removeAccountRequest = (id) => {   
        var data = {user_id: id};
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/remove.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=utf-8");
        xhr.onreadystatechange = () => {
            if(xhr.readyState==4){
                if(xhr.status==200){
                    document.getElementById(xhr.responseText.toString()).remove(); 
                }
            }
        }
        xhr.send('data='+JSON.stringify(data));
    };

    document.querySelectorAll('.accounts-list li').forEach((item) => {
        item.addEventListener('click', (e) => {
            if(e.target.tagName.toLowerCase() === "i"){
                let id = item.getAttribute("data-id");
                removeAccountRequest(id);
            }
        });
    })
})();

