import { Component } from '@angular/core';

@Component({
  selector: 'app-landing-page',
  standalone: false,
  templateUrl: './landing-page.component.html',
  styleUrl: './landing-page.component.css'
})
export class LandingPageComponent {
  lenguajeActual: string = 'es'; // Idioma inicial

  cambiarIdioma() {
    this.lenguajeActual = this.lenguajeActual === 'es' ? 'en' : 'es';
    // Aquí podrías implementar la lógica para cambiar el contenido de la página
    // según el idioma seleccionado. Esto podría implicar el uso de un servicio de
    // traducción o simplemente cambiar variables en el componente.
    console.log('Idioma seleccionado:', this.lenguajeActual);
  }
}
