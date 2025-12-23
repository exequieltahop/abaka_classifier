import './bootstrap';
import Swal from 'sweetalert2';
import '@tailwindplus/elements';
import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";
import Chart from 'chart.js/auto';

import * as tf from "@tensorflow/tfjs";
import * as tmImage from "@teachablemachine/image";

window.Toastify = Toastify;
window.Swal = Swal;
window.Chart = Chart;
