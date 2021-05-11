import {h, render} from 'preact';
import {Router, Link} from 'preact-router';

import '../assets/styles/app.scss';

import Home from './pages/home';
import Conference from './pages/conference';

function App() {
    return (
        <div>
            <header>
                <Link href="/">Home</Link>
                <br/>
                <Link href="/conference/samara2021">Samara 2021</Link>
            </header>

            <Router>
                <Home path="/" />
                <Conference path="/conference/samara2021" />
            </Router>
        </div>
    );
}

render(<App/>, document.getElementById('app'));
