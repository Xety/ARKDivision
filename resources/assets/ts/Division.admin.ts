import Sidebar from './Sidebar';
import Console from './Console/Console';

class Division
{
    constructor()
    {
        let sidebar: Sidebar = new Sidebar();

        this.renderConsoleMessages();
    }

    /**
     * Render the messages in the console.
     *
     * @return {void}
     */
    protected renderConsoleMessages()
    {
        var information = new Console({
            title: 'color:#a3f5a3;background:#2f4052;font-weight:bold;',
            message: "\n %c  %c Bonjour ! %c  %c  Si vous rencontrez un bug n'hésitez pas à contacter @ZoRo sur Discord.  %c  \n\n",
            width: 'padding:5px 0;',
            color: 'color:#fff;',
            primaryBackground: 'background:#5ccc5c;',
            cornerBackground: 'background:#a3f5a3;',
        });
        information.render();

        var warning = new Console({
            title: 'color:#e44;background:#2f4052;font-weight:bold;',
            message: "\n %c  %c ATTENTION %c  %c  N'EXÉCUTER PAS DE SCRIPT ICI! IL AURA UN ACCÈS COMPLET À VOTRE NAVIGATEUR ET À VOTRE COMPTE ! https://en.wikipedia.org/wiki/Self-XSS  %c  \n\n",
            width: 'padding:5px 0;',
            color: 'color:#fff;',
            primaryBackground: 'background:#c22;',
            cornerBackground: 'background:#e44;',
        });
        warning.render();
    }
}
const division = new Division();