window.onload = function(){
    randomVal();
}

function randomVal(){
    let textInputs = document.querySelectorAll("form input");
    for (let i = 0 ; i < textInputs.length ; i++){
        textInputs[i].value = Math.random().toString(36).substr(2, 7);
    }
}

function addSong(song, artist){
    let songTable = document.getElementById("songtable");
    let row = songTable.insertRow();
    let r = row.insertCell();
    let s = row.insertCell();
    let a = row.insertCell();
    r.innerHTML = songTable.rows.length - 1;
    s.innerHTML = song;
    a.innerHTML = artist;
}

function addSongMulti(csv){
    let songTable = document.getElementById("songtable");

    lines = csv.split("\n");
    for(let i = 0 ; i < lines.length ; i++){
        let entry = lines[i].split(",");
        let row = songTable.insertRow();
        let r = row.insertCell();
        let s = row.insertCell();
        let a = row.insertCell();
        r.innerHTML = songTable.rows.length - 1;
        s.innerHTML = entry[0];
        a.innerHTML = entry[1];
    }
}

function formatPOSTData(object) {
    var encodedString = '';
    for (var key in object) {
        if (object.hasOwnProperty(key)) {
            if (encodedString.length > 0) {
                encodedString += '&';
            }
            encodedString += encodeURI(key + '=' + object[key]);
        }
    }
    return encodedString;
}

function saveSong(){
    let url = './handle_input.php';

    let textInputs = document.querySelectorAll("form input");
    let save_songlist = '';
    let song = textInputs[0].value;
    let artist = textInputs[1].value;

    let xhr = new XMLHttpRequest();
    console.log(xhr);
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function(){
        if (xhr.status !== 200){
            alert('Something went wrong with submission.  Please contact Brendan.')
        }
        console.log(xhr.status);
    };
    let data = {
        save_songlist: '',
        song: song,
        artist: artist 
    };
    xhr.send(formatPOSTData(data));
    randomVal();
}

