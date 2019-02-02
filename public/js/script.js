window.onclick = function() {
    if (!event.target.matches('.dropdown')) {
      var dd = document.getElementById("dropFilterEvent");
      if (dd.classList.contains('show')) {
        dd.classList.remove('show');
      }
    }
}

function Drop(component) {
    document.getElementById(component).classList.toggle("show");
}

function HideEvent(eventStatus1, eventStatus2) {
  var status1 = document.getElementById(eventStatus1);
  var status2 = document.getElementById(eventStatus2);
  if (status1.classList.contains('show')) {
    status1.classList.remove('show');
    status2.classList.add('show');
  }
}

function ShowAll(eventStatus1, eventStatus2) {
  var status1 = document.getElementById(eventStatus1);
  var status2 = document.getElementById(eventStatus2);
  status1.classList.add('show');
  status2.classList.add('show');
}

function HideComment(comment, btncom) {
  document.getElementById(comment).classList.toggle("show");
  var value = document.getElementById(btncom);

  if (document.getElementById(comment).classList.contains("show")) {
    value.innerHTML = "voir moins de commentaires";
  } else  {
    value.innerHTML = "voir plus de commentaires";
  }
}