var $ = require('jquery');

global.$ = global.jQuery = $;


//const Swal = require('sweetalert2');
require('bootstrap');
//import Swal from 'sweetalert2/src/sweetalert2.js'

//Swal.fire('Any fool can use a computer')

/* Swal.fire({
    title: 'Submit your Github username',
    input: 'text',
    inputAttributes: {
        autocapitalize: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Look up',
    showLoaderOnConfirm: true,
    preConfirm: (login) => {
        return fetch(`//api.github.com/users/${login}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json()
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          )
        })
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.value) {
      Swal.fire({
        title: `${result.value.login}'s avatar`,
        imageUrl: result.value.avatar_url
      })
    }
  })
 */
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
