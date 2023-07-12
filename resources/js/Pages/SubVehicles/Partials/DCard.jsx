import { Card, Row, Col, Statistic} from 'antd';
import { CarOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';


const DCard = ({ propCard, propLinks }) => {
    const { permissions } = usePage().props?.auth || [];
    const { titleCard, totalCard } = propCard;
    const { editLink, showLink } = propLinks;

    return (
        <>
            <Card size='small' title={titleCard} className='shadow-md'>
                <Statistic title={"Total de vehículos "+titleCard} value={totalCard} prefix={<CarOutlined />} />
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