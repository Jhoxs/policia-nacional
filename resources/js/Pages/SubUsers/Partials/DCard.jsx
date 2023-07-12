import { Card, Row, Col, Button, Statistic, message, Popconfirm, App, Typography, Tooltip } from 'antd';
import { QuestionCircleOutlined, PlusOutlined } from '@ant-design/icons';
import { EnvironmentOutlined, EyeOutlined, UserOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';


const DCard = ({ propCard, propLinks }) => {
    const { permissions } = usePage().props?.auth || [];
    const { titleCard, totalCard } = propCard;
    const { editLink, showLink } = propLinks;

    return (
        <>
            <Card size='small' title={titleCard} className='shadow-md'>
                <Statistic title={"Total de usuarios "+titleCard} value={totalCard} prefix={<UserOutlined />} />
                <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                    <Col>
                        {/* {permissions.includes(editLink) && (
                            <>
                                <Link href={route(editLink, 1)}>
                                    <Tooltip title='Ver más'>
                                        <Button shape='round' icon={<EyeOutlined />} />
                                    </Tooltip>
                                </Link>
                            </>
                        )} */}
                    </Col>

                </Row>
            </Card>
        </>
    );
}

export default DCard