<?php

namespace Zrcms\ContentResourceUri\Schema;

class UriSchemaThemeLayout
{
    const SCHEMA = 'zrcms:theme-layout:{{template}}/{{path}}';
    const SCHEMA_REGEX = 'zrcms\:theme-layout\:(?<template>[^\/]+)\/(?<path>.*)';
}
