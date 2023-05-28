function dammiResponse(response) {
    console.log('2');
    console.log(response);
    return response.json().then(databaseResponse); 
  }
  
  function dammiError(error) { 
    console.log("Errore");
    console.log('9');
  }
  
  function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        console.log('15');
        return null;
    }
    console.log('18');
  }

  function salvaCanzone(c){
    console.log('Sto salvando la canzone');

    const formData= new FormData();

    formData.append('titolo',c.querySelector('h3').textContent);
    formData.append('poster',c.querySelector('img').src);
    formData.append('id',c.querySelector('h4').textContent);
    console.log('sono prima della fetch');
    
    fetch("salvaFilm.php",{method:'post',body:formData}).then(dammiResponse, dammiError);
    
}


function like(event){
    const contenitore=event.currentTarget;

    const cuore=contenitore.querySelector('.check');
    cuore.src="img/check.png";

    salvaCanzone(contenitore);
}

function reset(){
    const risultati=document.querySelector('.results');
    
    
    risultati.innerHTML=' ';
    return console.log('PULITO');
}


function jsonFilm(json) {
    
    console.log(json);

    if(document.querySelector('.results div')!=null){
console.log('suca');
reset()

    }
    
    const Film = json;

    console.log(Film.Poster);

    const results = document.querySelector('.results');
    
    const titolo=document.createElement('h3');
    const id=document.createElement('h4');
    id.textContent=Film.imdbID;
    titolo.textContent=Film.Title;
    const image = Film.Poster;
    const contenitore = document.createElement('div');
    const heart = document.createElement('img');
    const img = document.createElement('img');
    heart.src = "img/uncheck.png"
    img.src = image;

    heart.classList.add('check');



    contenitore.appendChild(img);
    contenitore.appendChild(titolo);
    contenitore.appendChild(id);
    contenitore.appendChild(heart);

    results.appendChild(contenitore);
    console.log(id.textContent);
    console.log(Film.imdbID);

    contenitore.addEventListener("click",like); 
    
    

    

}

function searchResponse(response) {
    console.log(response);
    
    return  response.json();
}

function search(event) {
    //PRENDO L'INPUT 
    const dati = document.getElementById("cerca");
    //MANDO I DATI DA CERCARE
    fetch("cercaFilm.php?q=" + encodeURIComponent(dati.value)).then(searchResponse).then(jsonFilm);
    event.preventDefault();
}




const button = document.getElementById("button");
console.log(button)
button.addEventListener('click', search)