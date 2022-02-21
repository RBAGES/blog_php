
const addBtn = document.getElementById('addCommentBtn')
const commentInput = document.getElementById('addANote')
const commentList = document.getElementById('commentlist')

//fonction qui crée le code html d'un commentaire avec son contenu et l'utilisateur qui l'a posté 
function createComment(content, user) {

const comment = `
<div class="card mb-4">
    <div class="card-body">
        <p>${content}</p>
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-row align-items-center">
                <img src="${(user.avatar != '') ? user.avatar : 'https://bip.cnrs.fr/wp-content/uploads/2019/11/user.jpg'}" alt="avatar" width="25" height="25" />
                <p class="small mb-0 ms-2 ${(user === 'admin') ? 'text-danger' : ''}">${user.pseudo}</p>
            </div>
            <div class="mb-1 text-muted">
                ${user.date}
            </div>
        </div>
    </div>
</div>`;
    return createElement(comment);
}


addBtn.addEventListener('click', (e) => {
    e.preventDefault();
    let comment = commentInput.value;
    if (comment === undefined)
        return;
    commentInput.value = '';
    let requestBody = {
        'contenu': comment,
        'article_id': id
    }

    let request = JSON.stringify(requestBody);

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let result = JSON.parse(this.responseText);
            const newComment = createComment(comment, result);
            commentList.insertBefore(newComment, commentList.querySelector('.card'));
        }
    }

    xhr.open('POST', 'index.php?route=new-comment-ajax', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('request=' + request);

});

// fonction qui crée un élément html à partir de la string passée
function createElement(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();

    return div.firstChild;
}

