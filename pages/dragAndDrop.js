function onDragStart(event) {
    //définir l'id de l'élément qu'on drag
    event
        .dataTransfer
        .setData('text/plain', event.target.id);
        
    //mise en jaune de l'équipe qu'on est entrain de drag
    event
        .currentTarget
        .style
        .backgroundColor = 'yellow';
}

//la div devient une zone de drop potentiel
function onDragOver(event) {
    event.preventDefault();
}

function onDrop(event) {
    const id = event
        .dataTransfer
        .getData('text/plain');

    //on récupère l'objet draggable
    const draggableElement = document.getElementById(id);

    //on récupère la cible
    const dropzone = event.target;

    //Deux cas : 
    //1) cas où la dropzone est une équipe => la dropzone devient son parent (la poule)
    if (dropzone.className !== 'poules') {  
        const dropzoneParent = event.target.parentNode;
        dropzoneParent.appendChild(draggableElement);
        //on clear les data transféré de la zone du départ
        event
            .dataTransfer
            .clearData();
    }
    //2) cas où la dropzone est bien une poule => on drop puis clear les data sans changer de cible
    else {
        dropzone.appendChild(draggableElement);
        event
            .dataTransfer
            .clearData();
    }
}