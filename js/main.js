(function() {

    const removeAccountRequest = (id) => {   
        var data = {user_id: id};
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/remove.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=utf-8");
        xhr.onreadystatechange = () => {
            if(xhr.readyState == 4 && xhr.status == 200){
                document.querySelectorAll('.account-item').forEach((item) => {
                    let uid = item.getAttribute("data-id").toString();
                    let responeid = xhr.responseText.replace(/\"/g, "");
                    if(uid == responeid){
                        item.parentNode.removeChild(item);
                    }
                })
            }
        }
        xhr.send('data='+JSON.stringify(data));
    };

    const removeSelectedAccountsRequest = () => {};

    const handleRemoveBtnEvent = (e) => {
        let classRemoved = false;
        document.querySelectorAll('.accounts-list li.account-item .account').forEach(
            (item) => {
                item.childNodes.forEach((node) => {
                    if(node.type === 'checkbox'){
                        if(e.target.innerText === "Remove accounts"){
                            node.classList.remove("hidden");
                            classRemoved = true;
                        }
                        else{
                            node.classList.add("hidden");
                            classRemoved = false;
                        }
                    }
                });
            }
        )

        e.target.innerText = classRemoved ? "Cancel" : "Remove accounts";
    }

    document.getElementById("remove-btn").addEventListener('click', (e) => { handleRemoveBtnEvent(e) });

    document.querySelectorAll('.accounts-list li').forEach((item) => {
        item.addEventListener('click', (e) => {
            if(e.target.tagName.toLowerCase() === "i"){
                let id = item.getAttribute("data-id");
                removeAccountRequest(id);
            }
        });
    })

})();

