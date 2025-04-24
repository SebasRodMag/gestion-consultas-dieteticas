import { Component } from '@angular/core';

@Component({
  selector: 'app-header',
  standalone: false,
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {
  currentLanguage: string = 'es'; // Idioma inicial

  toggleLanguage() {
    this.currentLanguage = this.currentLanguage === 'es' ? 'en' : 'es';
    // Aquí podrías implementar la lógica para cambiar el idioma de la aplicación
    console.log('Idioma seleccionado:', this.currentLanguage);
  }
}
