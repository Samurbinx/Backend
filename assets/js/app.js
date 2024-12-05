import 'bootstrap'; 
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

// Inicializa el tooltip de Bootstrap
const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new Tooltip(tooltipTriggerEl);
});
