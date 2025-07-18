import './bootstrap'
import '../css/app.css'

import ReactDOM from 'react-dom/client'
import Base from './Base'
import { GlobalProvider } from './contexts/GlobalContext';

ReactDOM.createRoot(document.getElementById('app')).render(
    <GlobalProvider>
        <Base/>
    </GlobalProvider>
)