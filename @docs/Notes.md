NOTES
=====



### HTTP ### 

app
core 1.20.4
admin 1.20.5
plugins 1.20.1
message 1.20.1
redirect-editor 1.20.1
rcm-user 1.3.1
i19n 1.20.3 -- todo tag

git commit -am "Fix ACL resource"

/** @var ResourceName $resourceName */
$resourceName = $this->getServiceLocator()->get(
    ResourceName::class
);

$resourceId = $resourceName->get(
    ResourceName::RESOURCE_SITES,
    $siteId,
    ResourceName::RESOURCE_PAGES,
    'n',
    $pageName
);


/** @var RcmUserService $rcmUserService */
$rcmUserService = $this->serviceLocator->get(RcmUserService::class);

$rcmUserService->isAllowed(
    ResourceName::RESOURCE_SITES,
    xxx
);
