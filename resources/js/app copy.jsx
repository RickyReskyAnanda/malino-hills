import './bootstrap'
import '../css/app.css'

import ReactDOM from 'react-dom/client'
import App from './Page/App'
import { GlobalProvider } from './Context/GlobalContext';
ReactDOM.createRoot(document.getElementById('app')).render(
    <GlobalProvider>
        <App/>
    </GlobalProvider>
)