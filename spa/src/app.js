import {h, render} from 'preact';
import {Router, Link} from 'preact-router';
import {useState, useEffect} from "preact/hooks";

import '../assets/styles/app.scss';

import {findConferences} from './api/api';
import Home from './pages/home';
import Conference from './pages/conference';

function App() {
    const [conferences, setConferences] = useState(null);

    useEffect(_ => {
        findConferences().then(setConferences);
    }, []);

    if (null === conferences) {
        return <div className="text-center pt-5">Loading...</div>
    }

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
                        {conferences.map(conference => (
                            <Link className="nav-conference" href={'/conference/' + conference.slug}>
                                {conference.city} {conference.year}
                            </Link>
                        ))}
                    </div>
                </nav>
            </header>

            <Router>
                <Home path="/" conferences={conferences}/>
                <Conference path="/conference/:slug" conferences={conferences}/>
            </Router>
        </div>
    );
}

render(<App/>, document.getElementById('app'));
