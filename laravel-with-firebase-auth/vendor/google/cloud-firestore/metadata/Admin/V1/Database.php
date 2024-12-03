<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/firestore/admin/v1/database.proto

namespace GPBMetadata\Google\Firestore\Admin\V1;

class Database
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Protobuf\Duration::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
(google/firestore/admin/v1/database.protogoogle.firestore.admin.v1google/api/resource.protogoogle/protobuf/duration.protogoogle/protobuf/timestamp.proto"�
Database
name (	
uid (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�A4
delete_time (2.google.protobuf.TimestampB�A
location_id	 (	>
type
 (20.google.firestore.admin.v1.Database.DatabaseTypeM
concurrency_mode (23.google.firestore.admin.v1.Database.ConcurrencyMode@
version_retention_period (2.google.protobuf.DurationB�A>
earliest_version_time (2.google.protobuf.TimestampB�Al
!point_in_time_recovery_enablement (2A.google.firestore.admin.v1.Database.PointInTimeRecoveryEnablementa
app_engine_integration_mode (2<.google.firestore.admin.v1.Database.AppEngineIntegrationMode

key_prefix (	B�AZ
delete_protection_state (29.google.firestore.admin.v1.Database.DeleteProtectionStateH
cmek_config (2..google.firestore.admin.v1.Database.CmekConfigB�A
previous_id (	B�AH
source_info (2..google.firestore.admin.v1.Database.SourceInfoB�A
etagc (	H

CmekConfig
kms_key_name (	B�A
active_key_version (	B�A�

SourceInfoM
backup (2;.google.firestore.admin.v1.Database.SourceInfo.BackupSourceH :
	operation (	B\'�A$
"firestore.googleapis.com/OperationD
BackupSource4
backup (	B$�A!
firestore.googleapis.com/BackupB
source�
EncryptionConfigx
google_default_encryption (2S.google.firestore.admin.v1.Database.EncryptionConfig.GoogleDefaultEncryptionOptionsH m
use_source_encryption (2L.google.firestore.admin.v1.Database.EncryptionConfig.SourceEncryptionOptionsH |
customer_managed_encryption (2U.google.firestore.admin.v1.Database.EncryptionConfig.CustomerManagedEncryptionOptionsH  
GoogleDefaultEncryptionOptions
SourceEncryptionOptions=
 CustomerManagedEncryptionOptions
kms_key_name (	B�AB
encryption_type"W
DatabaseType
DATABASE_TYPE_UNSPECIFIED 
FIRESTORE_NATIVE
DATASTORE_MODE"w
ConcurrencyMode 
CONCURRENCY_MODE_UNSPECIFIED 

OPTIMISTIC
PESSIMISTIC!
OPTIMISTIC_WITH_ENTITY_GROUPS"�
PointInTimeRecoveryEnablement1
-POINT_IN_TIME_RECOVERY_ENABLEMENT_UNSPECIFIED "
POINT_IN_TIME_RECOVERY_ENABLED#
POINT_IN_TIME_RECOVERY_DISABLED"b
AppEngineIntegrationMode+
\'APP_ENGINE_INTEGRATION_MODE_UNSPECIFIED 
ENABLED
DISABLED"
DeleteProtectionState\'
#DELETE_PROTECTION_STATE_UNSPECIFIED 
DELETE_PROTECTION_DISABLED
DELETE_PROTECTION_ENABLED:R�AO
!firestore.googleapis.com/Database\'projects/{project}/databases/{database}RB�
com.google.firestore.admin.v1BDatabaseProtoPZ9cloud.google.com/go/firestore/apiv1/admin/adminpb;adminpb�GCFS�Google.Cloud.Firestore.Admin.V1�Google\\Cloud\\Firestore\\Admin\\V1�#Google::Cloud::Firestore::Admin::V1�Ad
"firestore.googleapis.com/Operation>projects/{project}/databases/{database}/operations/{operation}bproto3'
        , true);

        static::$is_initialized = true;
    }
}

