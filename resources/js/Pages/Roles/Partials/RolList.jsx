import { Row, Col, Typography } from 'antd';
import RolCard from './RolCard';

const { Title } = Typography;

export default function RolList({ roles }) {

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Roles
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <Row gutter={[16, 24]}>
                {roles.map((rol) => (
                    <Col key={rol.id} xl={6} lg={8} md={12} sm={20} xs={24}>
                        <RolCard rol={rol} />
                    </Col>
                ))}
            </Row>
        </>
    );
} 