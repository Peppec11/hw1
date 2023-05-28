function fetchFilm() {
    fetch("favouriteFilm.php").then(fetchResponse).then(fetchFilmJson);
}
function fetchEliminazione(json){
    console.log(json);
}

function fetchResponse(response) {
    if (!response.ok) { return null };
    return response.json();
}

function rimuovi(event){
    console.log(event.currentTarget)
    const frame=event.currentTarget.parentNode;
    const film=document.getElementById('film')

    console.log(frame);
    console.log(frame.dataset.id);

    fetch("eliminaFilm.php?q="+encodeURIComponent(frame.dataset.id)).then(fetchResponse).then(fetchEliminazione);
     film.removeChild(frame);
}
function fetchFilmJson(json) {
    console.log(json);

    if (!json.length) { noResults(); return; }

    const container = document.getElementById('music');

    /*container.innerHTML='';
    container.className='FilmFLix'*/
    const films = json;

    if (films.length > 0) {
        const box = document.querySelector('.favourite');
        const title = document.createElement('h2');
        title.textContent = 'I Tuoi film preferiti';

        box.appendChild(title);
    }
    

    for (let i = 0; i <= films.length; i++) {
        console.log('Aggiungo il film=> ' + films[i].filmid);
        const film = document.getElementById('film');
        const frame = document.createElement('div');
        frame.dataset.id = films[i].filmid;
        const titolo = document.createElement('h5');
        const img = document.createElement('img');
        const x = document.createElement('img');
        titolo.textContent = films[i].content.title;
        img.src = films[i].content.poster;
        x.src = 'img/canc.png';

        frame.appendChild(x);
        frame.appendChild(img);
        frame.appendChild(titolo);
        film.appendChild(frame);

        film.classList.add('box');
        frame.classList.add('frame');
        x.classList.add('canc');

     x.addEventListener('click',rimuovi);

    }

}

fetchFilm();