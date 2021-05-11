import {h, render} from 'preact';
import {Router, Link} from 'preact-router';

import '../assets/styles/app.scss';

import Home from './pages/home';
import Conference from './pages/conference';

function App() {
    return (
        <div>
            <header className="header">
                <nav className="navbar navbar-light bg-light">
                    <div className="container">
                        <Link className="navbar-brand mr-4 pr-2" href="/">
                            &#128217; Guestbook
                        </Link>
                    </div>
                </nav>
                <nav className="bg-light bg-bottom text-center">
                    <div className="container">
                        <Link className="nav-conference" href="/conference/samara2021">
                            Samara 2021
                        </Link>
                    </div>
                </nav>
            </header>

            <Router>
                <Home path="/"/>
                <Conference path="/conference/samara2021"/>
            </Router>
        </div>
    );
}

render(<App/>, document.getElementById('app'));
