function jsonCommenti(json) {
    console.log(json);

    const comments = json;

    for (const comment of comments) {
        const post = document.querySelector('.post');
        const div = document.createElement('div');
        const userBox= document.createElement('div');
        const avatar=document.createElement('img');
        const name = document.createElement('h3');
        const data = document.createElement('h4');
        const testo = document.createElement('p');
        const separatore = document.createElement('div');

        name.textContent = comment.content.username;
        data.textContent = comment.content.data;
        testo.textContent = comment.content.comment;
        avatar.src=comment.content.avatar;

        separatore.classList.add('separatore');
        userBox.classList.add('userComment')

        userBox.appendChild(avatar);
        userBox.appendChild(name);
        div.appendChild(userBox);
        div.appendChild(data);
        div.appendChild(testo);

        post.appendChild(div);
        post.appendChild(separatore);

    }

}

function onResponse(response) {
    console.log(response);

    return response.json();
}

function cercaCommenti(event) {
    fetch("cercaCommenti.php").then(onResponse).then(jsonCommenti);
    event.preventDefault();
}






const commenta = document.querySelector('.button');
console.log(commenta);
commenta.addEventListener('clik', cercaCommenti);
addEventListener('load', cercaCommenti);