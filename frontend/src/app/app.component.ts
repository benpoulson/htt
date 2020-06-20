import {Component} from '@angular/core';
import {setTheme} from 'ngx-bootstrap/utils';

@Component({
    selector: 'app-root',
    templateUrl: 'app.component.html',
    styles: []
})
export class AppComponent {

    constructor() {
        setTheme('bs4');
    }

    title = 'htt-frontend';
}
