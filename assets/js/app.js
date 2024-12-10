import 'bootstrap'; 
import 'sweetalert2'; 
import '../css/general/styles.css';
import '../css/general/buttons.css';
import '../css/general/forms.css';
import '../css/general/tables.css';
import '../css/components/page.css';
import '../css/components/artwork.css';
import '../css/components/piece.css';
import '../css/components/work.css';
import '../css/components/material.css';
import '../css/components/user.css';
import '../css/components/order.css';

import { Tooltip, Toast, Popover } from 'bootstrap';
import Swal from 'sweetalert2'; 


// Inicializa el tooltip de Bootstrap
const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new Tooltip(tooltipTriggerEl);
});

document.addEventListener('DOMContentLoaded', () => {
  // Selecciona todos los formularios con la clase `delete-form`
  const deleteForms = document.querySelectorAll('.delete-form');

  deleteForms.forEach(form => {
      form.addEventListener('submit', event => {
          event.preventDefault(); // Detiene el envío del formulario

          Swal.fire({
              title: '¿Estás seguro?',
              text: 'Esta acción no se puede deshacer.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, borrar',
              cancelButtonText: 'Cancelar'
          }).then(result => {
              if (result.isConfirmed) {
                  // Envía el formulario si el usuario confirma
                  form.submit();
              }
          });
      });
  });
});
