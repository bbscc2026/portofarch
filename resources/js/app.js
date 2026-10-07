import Alpine from 'alpinejs';
import { initHeader } from './header';
import { initMotion } from './motion';

window.Alpine = Alpine;

Alpine.start();

initHeader();
initMotion();
