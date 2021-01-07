//Allow to only show the job selected by the User
function showOnlySelectedJob() {
  let element = document.getElementById('profile_user_professions_first');

  let inputs = element.getElementsByTagName('input');

  for( let i = 0; i < inputs.length; i++ ) {
    let status = inputs[i].checked;
    console.log(inputs[i].id);

    if (status == false) {
      inputs[i].style.display = "none";
      label = element.querySelector('label[for="' + inputs[i].id + '"]' );
      label.style.display = "none";
    }
  }
}

//Add a line break a twig row that can't be accessed otherwise
function addLineBreak(idHTML) {
  let element = document.querySelector('label[for="' + idHTML + '"]');
  element.style.fonteWeight = "bold";
  element.insertAdjacentHTML('afterend', '<br>');

}

showOnlySelectedJob();
addLineBreak("profile_user_salutation");
addLineBreak("profile_user_firstName");
addLineBreak("profile_user_lastName");
addLineBreak("profile_user_phoneNumber");
addLineBreak("profile_user_professions_second");


