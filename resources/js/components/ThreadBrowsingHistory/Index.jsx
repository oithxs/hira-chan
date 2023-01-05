import React from 'react';
import ReactDOM from 'react-dom/client';
import { History } from './History';

const Index = () => {
    const [thread, setThread] = React.useState({});
    const element = document.getElementById('thread_browsing_history');
    const history = JSON.parse(element.dataset.history);

    return (
        <div className='container'>
            <div className='row'>
                <div className='py-8 col-5'>
                    <History history={history} onClick={(data) => setThread(data)}/>
                </div>
                <div className='col-2'></div>
                <div className='py-8 col-5'>
                    {/* Posts */}
                </div>
            </div>
        </div>
    );
}

const threadBrowsingHistory = ReactDOM.createRoot(document.getElementById('thread_browsing_history'));
threadBrowsingHistory.render(<Index/>);
