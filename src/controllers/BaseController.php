<?php
namespace verbb\workflow\controllers;

use verbb\workflow\Workflow;

use Craft;
use craft\db\Table;
use craft\elements\User;
use craft\helpers\Db;
use craft\web\Controller;

use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BaseController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionSettings(): Response
    {
        $settings = Workflow::$plugin->getSettings();

        $publishers = [];

        if ($settings->publisherUserGroup) {
            $publisherUserGroupId = Db::idByUid(Table::USERGROUPS, $settings->publisherUserGroup);

            foreach (User::find()->groupId($publisherUserGroupId)->all() as $user) {
                $publishers[] = ['value' => $user->id, 'label' => $user];
            }
        }

        return $this->renderTemplate('workflow/settings', [
            'settings' => $settings,
            'publishers' => $publishers,
        ]);
    }

    public function actionSavePluginSettings(): ?Response
    {
        $currentUser = Craft::$app->getUser()->getIdentity();

        if (!$currentUser->can('workflow:settings')) {
            throw new ForbiddenHttpException('User is not permitted to perform this action.');
        }

        $this->requirePostRequest();

        $pluginHandle = Craft::$app->getRequest()->getRequiredBodyParam('pluginHandle');
        $settings = Craft::$app->getRequest()->getBodyParam('settings', []);
        $plugin = Craft::$app->getPlugins()->getPlugin($pluginHandle);

        if ($plugin === null) {
            throw new NotFoundHttpException('Plugin not found');
        }

        if (!Craft::$app->getPlugins()->savePluginSettings($plugin, $settings)) {
            Craft::$app->getSession()->setError(Craft::t('app', "Couldn't save plugin settings."));

            // Send the plugin back to the template
            Craft::$app->getUrlManager()->setRouteParams([
                'plugin' => $plugin,
            ]);

            return null;
        }

        Craft::$app->getSession()->setNotice(Craft::t('app', 'Plugin settings saved.'));

        return $this->redirectToPostedUrl();
    }
}
