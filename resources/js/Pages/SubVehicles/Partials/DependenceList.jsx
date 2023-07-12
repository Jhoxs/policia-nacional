import { Card, Row, Col, Button, Statistic, message, Popconfirm, App, Typography, Tooltip } from 'antd';
import { QuestionCircleOutlined, PlusOutlined } from '@ant-design/icons';
import { EnvironmentOutlined, EyeOutlined, OrderedListOutlined } from '@ant-design/icons';
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';

import DCard from './DCard';

const { Title } = Typography;

const DependenceList = ({ dependeces }) => {
    const { permissions } = usePage().props?.auth || [];

    const { d_unotsubcircuits, d_usubcircuits} = dependeces;

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Vehículos Subcircuitos
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <Row gutter={[16, 24]}>
                <Col xl={6} lg={8} md={12} sm={20} xs={24}>
                    <DCard
                        propCard={d_usubcircuits}
                        propLinks={{
                            showLink: 'province.index',
                            editLink: 'province.index'
                        }}
                    />
                </Col>
                <Col xl={6} lg={8} md={12} sm={20} xs={24}>
                    <DCard
                        propCard={d_unotsubcircuits}
                        propLinks={{
                            showLink: 'parish.index',
                            editLink: 'parish.index'
                        }}
                    />
                </Col>
            </Row>
        </>
    );
}


export default DependenceList