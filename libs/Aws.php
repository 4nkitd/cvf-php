<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\ObjectUploader;

/**
 * AWS Wrapper
 *
 * @package		aws_package_client
 * @category	wrapper for AWS
 * @author		Ankit Yadav
 * @link		
 */

class Aws
{
    public $aws_key;
    public $aws_secret;
    public $region;

    protected $aws_client;

    public function __construct(
        string $aws_key = '',
        string $aws_secret = '',
        string $region = ''
    ) {
        $this->set_auth_keys($aws_key, $aws_secret, $region);
    }

    public function set_auth_keys(string $aws_key, string $aws_secret, string $region)
    {
        $this->aws_key = $aws_key;
        $this->aws_secret = $aws_secret;
        $this->region = $region;
    }

    public function process_aws_auth()
    {
        $config = [
            'region' => $this->region,
            'version' => '2006-03-01',
            'credentials' => [
                'key' => $this->aws_key,
                'secret' => $this->aws_secret,
            ]
        ];

        return $this->aws_client = new S3Client($config);
    }

    public function upload_s3_obj(
        string $bucketName,
        string $body,
        string $FilePath = '/',
        string $ACL = 'public-read'
    ) {

        try {
            return $this->aws_client->putObject([
                'Bucket' => $bucketName,
                'Key'    => $FilePath,
                'Body'   => $body,
                'ACL'    => $ACL
            ]);
        } catch (AwsException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete_s3_obj(string $bucketName, string $FilePath)
    {
        return $this->aws_client->deleteObject([
            'Bucket' => $bucketName,
            'Key'    => $FilePath
        ]);
    }

    public function copy_s3_obj(
        string $targetBucket,
        string $NewFilePath,
        string $sourceBucket,
        string $sourceKeyname
    ) {
        return $this->aws_client->copyObject([
            'Bucket'     => $targetBucket,
            'Key'        => $NewFilePath,
            'CopySource' => "{$sourceBucket}/{$sourceKeyname}",
        ]);
    }

    public function list_buckets()
    {
        return $this->aws_client->listBuckets();
    }

    public function create_bucket(string $NewbucketName)
    {
        try {
            return $this->aws_client->createBucket([
                'Bucket' => $NewbucketName,
            ]);
        } catch (AwsException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function get_bucket_cros(string $bucketName)
    {
        try {
            return $this->aws_client->getBucketCors([
                'Bucket' => $bucketName,
            ]);
        } catch (AwsException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function set_bucket_cros(
        string $bucketName,
        array $config = array(
            'AllowedHeaders' => ['Authorization'],
            'AllowedMethods' => ['POST', 'GET', 'PUT'],
            'AllowedOrigins' => ['*'],
            'ExposeHeaders' => [],
            'MaxAgeSeconds' => 3000
        )
    ) {
        try {
            return $this->aws_client->putBucketCors([
                'Bucket' => $bucketName,
                'CORSConfiguration' => [
                    'CORSRules' => $config,
                ]
            ]);
        } catch (AwsException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}